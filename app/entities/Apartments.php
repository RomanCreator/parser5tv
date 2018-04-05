<?php

namespace entities;


class Apartments extends Entity {
    protected $address = '';
    protected $amountPhoto = 0;
    protected $rooms = 0;
    protected $footage = '';
    protected $floor = '';
    protected $typeBuilding = '';
    protected $price = 0;
    protected $currency = '';

    public function __construct($address, $amountPhoto, $rooms, $footage, $floor, $typeBuilding, $price, $currency) {
        $this->address = $address;
        $this->amountPhoto = $amountPhoto;
        $this->rooms = $rooms;
        $this->footage = $footage;
        $this->floor = $floor;
        $this->typeBuilding = $typeBuilding;
        $this->price = $price;
        $this->currency = $currency;
    }

    public function getId() {
        return null;
    }

    public function getName() {
        return $this->getAddress();
    }

    public function getAddress() {
        return $this->address;
    }

    public function getAmauntPhoto() {
        return $this->amountPhoto;
    }

    public function getRooms() {
        return $this->rooms;
    }

    public function getFootage() {
        return $this->footage;
    }

    public function getFloor() {
        return $this->floor;
    }

    public function getTypeBuilding() {
        return $this->typeBuilding;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getCurrency() {
        return $this->currency;
    }
}