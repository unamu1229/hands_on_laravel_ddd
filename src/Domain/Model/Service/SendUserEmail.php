<?php


namespace src\Domain\Model\Service;


use src\Domain\Model\ValueObject\UserId;
use src\Infrastructure\UserRepository;

class SendUserEmail
{
    private $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function send(UserId $userId)
    {
        $user = $this->userRepo->byId($userId);
        // emailを送る処理
        return true;
    }
}