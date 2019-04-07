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

        for ($i = 1; $i <=40; $i++) {
            // イベントを作成しておく
            $this->reservationService->reserveParking(
                new ParkingId(uniqid()),
                new UserId(uniqid()),
                new Carbon()
            );
        }

        $response = $this->get(route('reserve.reserve_parking_events'), ['Authorization' => 'Bearer abcd1234']);
        $response->assertStatus(200);

        $endPoint = route('reserve.reserve_parking_events');
        $this->assertSame("<{$endPoint}/41,60>; rel=self",
            $response->headers->get('Link-self')
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


    public function testReservationParkingEventRange()
    {
        // ApiTokenを設定しておく
        $this->seed(\ApiTokensSeeder::class);

        for ($i = 1; $i <=50; $i++) {
            // イベントを作成しておく
            $this->reservationService->reserveParking(
                new ParkingId(uniqid()),
                new UserId(uniqid()),
                new Carbon()
            );
        }

        $response = $this->get(route('reserve.reserve_parking_events_range', ['start' => 20, 'end' => 40]), ['Authorization' => 'Bearer abcd1234']);
        $response->assertStatus(200);
    }
}
