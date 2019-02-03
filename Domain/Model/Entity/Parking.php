<?php


namespace Domain\Model\Entity;


use Domain\Exception\DomainException;
use Domain\Model\ValueObject\ParkingId;
use Domain\Model\ValueObject\ParkingPrice;

class Parking
{

    private $id;

    private $name;

    /** @var ParkingPrice */
    private $priceDay;

    /** @var ParkingPrice */
    private $priceTime;

    public function __construct(ParkingId $parkingId)
    {
        $this->setId($parkingId);
    }

    public function setId(ParkingId $parkingId)
    {
        if ($this->id != null) {
            throw new DomainException('すでに識別子が設定されています');
        }

        $this->id = $parkingId;
    }


    /**
     * @param ParkingPrice $parkingPrice
     */
    public function setPriceDay(ParkingPrice $parkingPrice): void
    {
        $this->priceDay = $parkingPrice;
    }


    /**
     * @param ParkingPrice $priceTime
     */
    public function setPriceTime(ParkingPrice $priceTime): void
    {
        if ($this->priceDay->getPrice() == null) {
            throw new DomainException('日貸し料金を設定しないと、時間貸しの料金は設定できません');
        }

        if (($priceTime->getPrice() * 4 * 12) < $this->priceDay->getPrice()) {
            throw new DomainException('日貸で借りた方が得な値にしてください');
        }

        $this->priceTime = $priceTime;
    }

}