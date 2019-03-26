<?php


namespace src\Domain\Model\Entity;


use src\Domain\Model\ValueObject\UserId;

class User
{
    private $id;

    public function __construct(UserId $id)
    {
        $this->id = $id;
    }
}