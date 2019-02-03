<?php


namespace Domain\Model\ValueObject;


class ParkingPrice
{

    const TAX_RATE = 0.8;

    private $price;

    public function __construct($price)
    {
        $this->price = $price;
    }

    public function getTaxPrice()
    {
        return $this->price * self::TAX_RATE;
    }

    public function getPrice()
    {
        return $this->price;
    }
}