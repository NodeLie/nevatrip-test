<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Order;

class OrderService
{
    private $client;
    private $em;

    public function __construct(HttpClientInterface $client, EntityManagerInterface $em)
    {
        $this->client = $client;
        $this->em = $em;
    }

    public function generateBarcode(): string
    {
        // Генерация случайного штрих-кода (можно добавить свою логику уникальности)
        return 'barcode_' . rand(1000000000, 9999999999);
    }

    public function bookOrder($eventId, $eventDate, $adultPrice, $adultQuantity, $kidPrice, $kidQuantity): string
    {
        // Генерация уникального штрих-кода
        $barcode = $this->generateBarcode();
    
        // Подготовка данных для бронирования
        $data = [
            'event_id' => $eventId,
            'event_date' => $eventDate,
            'ticket_adult_price' => $adultPrice,
            'ticket_adult_quantity' => $adultQuantity,
            'ticket_kid_price' => $kidPrice,
            'ticket_kid_quantity' => $kidQuantity,
            'barcode' => $barcode,
        ];
    
        // Замокированные ответы
        $mockResponses = [
            ['error' => null, 'message' => 'order successfully booked'],
            ['error' => 'barcode already exists', 'message' => null],
        ];
    
        // Выбор случайного ответа
        $response = $mockResponses[array_rand($mockResponses)];
        
        if (isset($response['error']) && $response['error'] === 'barcode already exists') {
            // Если ошибка, генерируем новый штрих-код и повторяем попытку
            return $this->bookOrder($eventId, $eventDate, $adultPrice, $adultQuantity, $kidPrice, $kidQuantity);
        }
    
        // Возвращаем сообщение о том, что заказ успешно забронирован
        return $response['message'] ?? 'Unknown error';
    }
    
    public function approveOrder($barcode): string
    {
        // Замокированные ответы
        $mockResponses = [
            ['error' => null, 'message' => 'order successfully approved'],
            ['error' => 'order not found', 'message' => null],
        ];
    
        // Выбор случайного ответа
        $response = $mockResponses[array_rand($mockResponses)];
    
        if (isset($response['error'])) {
            return $response['error'];
        }
    
        return $response['message'] ?? 'Unknown error';
    }

    public function saveOrder($eventId, $eventDate, $adultPrice, $adultQuantity, $kidPrice, $kidQuantity)
    {
        // Сначала бронируем заказ
        $bookResponse = $this->bookOrder($eventId, $eventDate, $adultPrice, $adultQuantity, $kidPrice, $kidQuantity);

        if ($bookResponse !== 'order successfully booked') {
            throw new \Exception('Booking failed: ' . $bookResponse);
        }

        // Генерация уникального штрих-кода
        $barcode = $this->generateBarcode();

        // Подтверждаем заказ
        $approveResponse = $this->approveOrder($barcode);

        if ($approveResponse !== 'order successfully approved') {
            throw new \Exception('Order approval failed: ' . $approveResponse);
        }

        // Вычисляем общую сумму
        $equalPrice = ($adultPrice * $adultQuantity) + ($kidPrice * $kidQuantity);

        // Сохраняем заказ в базу данных
        $order = new Order();
        $order->setEventId($eventId)
            ->setEventDate($eventDate)
            ->setTicketAdultPrice($adultPrice)
            ->setTicketAdultQuantity($adultQuantity)
            ->setTicketKidPrice($kidPrice)
            ->setTicketKidQuantity($kidQuantity)
            ->setBarcode($barcode)
            ->setEqualPrice($equalPrice)
            ->setCreated(new \DateTime());

        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }
}
