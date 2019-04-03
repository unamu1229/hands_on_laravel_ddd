<?php

namespace Tests\Feature;

use src\Application\ReservationService;
use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\UserId;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    /** @var ReservationService */
    private $reservationService;

    public function setUp()
    {
        parent::setUp();
        $this->reservationService = $this->app->make(ReservationService::class);
    }

    public function testReservationParkingEvents()
    {
        // ApiTokenを設定しておく
        $this->seed(\ApiTokensSeeder::class);
        // イベントを作成しておく
        $this->reservationService->reserveParking(
            new ParkingId(uniqid()),
            new UserId(uniqid()),
            new Carbon()
        );

        $response = $this->get(route('reserve.reserve_parking_events'), ['Authorization' => 'Bearer abcd1234']);
        $response->assertStatus(200);
        $this->assertSame(
            'http://localhost/api/reserve/reserve_parking_events/1,1; rel=self',
            $response->headers->get('Link')
        );
    }


    /**
     * イベントが存在しない場合
     */
    public function testReservationParkingEventCaseNoEvent()
    {
        // ApiTokenを設定しておく
        $this->seed(\ApiTokensSeeder::class);
        $response = $this->get(route('reserve.reserve_parking_events'), ['Authorization' => 'Bearer abcd1234']);
        $response->assertStatus(200);
    }
}
