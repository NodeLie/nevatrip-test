<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private int $event_id;

    #[ORM\Column(type: 'string', length: 10)]
    private string $event_date;

    #[ORM\Column(type: 'integer')]
    private int $ticket_adult_price;

    #[ORM\Column(type: 'integer')]
    private int $ticket_adult_quantity;

    #[ORM\Column(type: 'integer')]
    private int $ticket_kid_price;

    #[ORM\Column(type: 'integer')]
    private int $ticket_kid_quantity;

    #[ORM\Column(type: 'string', length: 120)]
    private string $barcode;

    #[ORM\Column(type: 'integer')]
    private int $equal_price;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventId(): int
    {
        return $this->event_id;
    }

    public function setEventId(int $event_id): self
    {
        $this->event_id = $event_id;
        return $this;
    }

    public function getEventDate(): string
    {
        return $this->event_date;
    }

    public function setEventDate(string $event_date): self
    {
        $this->event_date = $event_date;
        return $this;
    }

    public function getTicketAdultPrice(): int
    {
        return $this->ticket_adult_price;
    }

    public function setTicketAdultPrice(int $ticket_adult_price): self
    {
        $this->ticket_adult_price = $ticket_adult_price;
        return $this;
    }

    public function getTicketAdultQuantity(): int
    {
        return $this->ticket_adult_quantity;
    }

    public function setTicketAdultQuantity(int $ticket_adult_quantity): self
    {
        $this->ticket_adult_quantity = $ticket_adult_quantity;
        return $this;
    }

    public function getTicketKidPrice(): int
    {
        return $this->ticket_kid_price;
    }

    public function setTicketKidPrice(int $ticket_kid_price): self
    {
        $this->ticket_kid_price = $ticket_kid_price;
        return $this;
    }

    public function getTicketKidQuantity(): int
    {
        return $this->ticket_kid_quantity;
    }

    public function setTicketKidQuantity(int $ticket_kid_quantity): self
    {
        $this->ticket_kid_quantity = $ticket_kid_quantity;
        return $this;
    }

    public function getBarcode(): string
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): self
    {
        $this->barcode = $barcode;
        return $this;
    }

    public function getEqualPrice(): int
    {
        return $this->equal_price;
    }

    public function setEqualPrice(int $equal_price): self
    {
        $this->equal_price = $equal_price;
        return $this;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function setCreated(\DateTime $created): self
    {
        $this->created = $created;
        return $this;
    }
}