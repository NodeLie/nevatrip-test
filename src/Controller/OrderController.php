<?php
namespace App\Controller;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    #[Route("/order/create", name:"order_create", methods:["POST"])]

    public function createOrder(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        
        $eventId = $data['event_id'] ?? null;
        $eventDate = $data['event_date'] ?? null;
        $adultPrice = $data['ticket_adult_price'] ?? null;
        $adultQuantity = $data['ticket_adult_quantity'] ?? null;
        $kidPrice = $data['ticket_kid_price'] ?? null;
        $kidQuantity = $data['ticket_kid_quantity'] ?? null;
        
        try {
            $order = $this->orderService->saveOrder($eventId, $eventDate, $adultPrice, $adultQuantity, $kidPrice, $kidQuantity);

            return new Response('Order created successfully: ' . $order->getId(), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new Response('Error: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}