<?php

namespace Tests\Unit\Service;

use Carbon\Carbon;
use src\Application\EventService;
use src\Domain\Model\Event\ReservationParking;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\UserId;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventServiceTest extends TestCase
{

    /** @var EventService */
    private $eventService;

    public function setUp()
    {
        parent::setUp();
        $this->eventService = $this->app->make(EventService::class);
    }


    public function testStore()
    {

            $this->eventService->store(
                new ReservationParking(new ParkingId(uniqid()), new UserId(uniqid()), new Carbon())
            );
            $this->assertTrue(true);
    }
}
