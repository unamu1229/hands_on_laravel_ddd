<?php

namespace Tests\Unit\Service;

use Carbon\Carbon;
use src\Application\EventService;
use src\Application\ReservationService;
use src\Domain\Model\Event\ReservationParking;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\UserId;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventServiceTest extends TestCase
{

    use RefreshDatabase;

    /** @var EventService */
    private $eventService;

    /** @var ReservationService */
    private $reservationService;

    public function setUp()
    {
        parent::setUp();
        $this->eventService = $this->app->make(EventService::class);
        $this->reservationService = $this->app->make(ReservationService::class);
    }


    public function testStore()
    {
        $this->eventService->store(
            new ReservationParking(new ParkingId(uniqid()), new UserId(uniqid()), new Carbon())
        );
        $this->assertTrue(true);
    }

    public function testCurrentEvents()
    {
        $this->seed(\ApiTokensSeeder::class);
        // イベントを作成しておく
        $this->reservationService->reserveParking(
            new ParkingId(uniqid()),
            new UserId(uniqid()),
            new Carbon()
        );
        
        $currentEvents = $this->eventService->currentEvents();

        $this->assertTrue(true);
    }
}
