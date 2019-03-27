<?php


namespace src\Infrastructure;


use src\Domain\Model\Entity\User;
use src\Domain\Model\ValueObject\UserId;

class UserRepository
{
    public function byId(UserId $userId)
    {
        return new User($userId);
    }
}