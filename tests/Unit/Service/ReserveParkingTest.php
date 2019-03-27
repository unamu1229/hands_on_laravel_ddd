<?php

namespace Tests\Unit\Service;

use Carbon\Carbon;
use src\Application\ReservationService;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\UserId;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReserveParkingTest extends TestCase
{
    /** @var ReservationService */
    private $reservationService;

    public function setUp()
    {
        parent::setUp();
        $this->reservationService = $this->app->make(ReservationService::class);
    }

    public function testReserve()
    {
        $this->assertTrue(
            $this->reservationService->reserveParking(
                new ParkingId(uniqid()),
                new UserId(uniqid()),
                new Carbon()
            )
        );
    }
}
