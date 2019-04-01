<?php


namespace src\Domain\Model\Event;


use Carbon\Carbon;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\UserId;

class ReservationParking implements DomainEvent, \JsonSerializable
{
    private $parkingId;

    private $userId;

    private $occurredOn;

    public function __construct(ParkingId $parkingId, UserId $userId, Carbon $date)
    {
        $this->parkingId = $parkingId;
        $this->userId = $userId;
        $this->occurredOn = $date;
    }

    /**
     * @return ParkingId
     */
    public function getParkingId(): ParkingId
    {
        return $this->parkingId;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }


    public function occurredOn(): Carbon
    {

        return $this->occurredOn;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'parking_id' => $this->parkingId->getId(),
            'user_id' => $this->userId->id(),
            'occurred_on' => $this->occurredOn
        ];
    }
}