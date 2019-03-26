<?php

namespace Tests\Unit\Service;

use Carbon\Carbon;
use src\Domain\Model\Service\ReserveParking;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\UserId;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReserveParkingTest extends TestCase
{
    /** @var ReserveParking */
    private $reserveParking;

    public function setUp()
    {
        parent::setUp();
        $this->reserveParking = $this->app->make(ReserveParking::class);
    }

    public function testReserve()
    {
        $this->assertTrue(
            $this->reserveParking->reserve(
                new ParkingId(uniqid()),
                new UserId(uniqid()),
                new Carbon()
            )
        );
    }
}
