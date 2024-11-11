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
        $eventId = $request->request->get('event_id');
        $eventDate = $request->request->get('event_date');
        $adultPrice = $request->request->get('ticket_adult_price');
        $adultQuantity = $request->request->get('ticket_adult_quantity');
        $kidPrice = $request->request->get('ticket_kid_price');
        $kidQuantity = $request->request->get('ticket_kid_quantity');

        try {
            $order = $this->orderService->saveOrder($eventId, $eventDate, $adultPrice, $adultQuantity, $kidPrice, $kidQuantity);

            return new Response('Order created successfully: ' . $order->getId(), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new Response('Error: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}