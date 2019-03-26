<?php


namespace src\Domain\Model\Entity;


use src\Domain\Exception\DomainException;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\ParkingPrice;

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
     * @return int|null
     */
    public function getPriceDay(): ?int
    {
        return $this->priceDay->getPrice();
    }


    /**
     * @param ParkingPrice $priceTime
     */
    public function setPriceTime(ParkingPrice $priceTime): void
    {
        if ($this->getPriceDay() == null) {
            throw new DomainException('日貸し料金を設定しないと、時間貸しの料金は設定できません');
        }

        if ($this->IsValidPriceTime($priceTime)) {
            throw new DomainException('日貸で借りた方が得な値にしてください');
        }

        $this->priceTime = $priceTime;
    }


    public function IsValidPriceTime(ParkingPrice $priceTime)
    {
        return ($priceTime->getPrice() * 4 * 12) < $this->priceDay->getPrice();
    }

}