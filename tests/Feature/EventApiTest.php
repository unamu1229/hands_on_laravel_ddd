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

    private $endPoint;


    public function setUp()
    {
        parent::setUp();
        $this->reservationService = $this->app->make(ReservationService::class);
        $this->endPoint = route('reserve.reserve_parking_events');

        $this->seed(\ApiTokensSeeder::class);
    }

    /**
     * @param $eventAmount
     * @param $range
     * @dataProvider provideTestReservationParkingEvents
     */
    public function testReservationParkingEvents($eventAmount, $range)
    {
        for ($i = 1; $i <=$eventAmount; $i++) {
            // イベントを作成しておく
            $this->reservationService->reserveParking(
                new ParkingId(uniqid()),
                new UserId(uniqid()),
                new Carbon()
            );
        }

        $response = $this->get(route('reserve.reserve_parking_events'), ['Authorization' => 'Bearer abcd1234']);
        $response->assertStatus(200);

        $this->assertSame(
            "<{$this->endPoint}/{$range}>; rel=self",
            $response->headers->get('Link-self')
        );
    }


    public function provideTestReservationParkingEvents()
    {
        return [
            [40, '21,40'],
            [0, '1,20'],
            [1, '41,60']
        ];
    }


    /**
     * イベントが存在しない場合
     */
    public function testReservationParkingEventCaseNoEvent()
    {
        $response = $this->get(route('reserve.reserve_parking_events'), ['Authorization' => 'Bearer abcd1234']);
        $response->assertStatus(200);
    }


    public function testReservationParkingEventRange()
    {

        for ($i = 1; $i <=50; $i++) {
            // イベントを作成しておく
            $this->reservationService->reserveParking(
                new ParkingId(uniqid()),
                new UserId(uniqid()),
                new Carbon()
            );
        }

        $response = $this->get(route('reserve.reserve_parking_events_range', ['start' => 21, 'end' => 40]), ['Authorization' => 'Bearer abcd1234']);
        $response->assertStatus(200);
        $this->assertSame(
            "<{$this->endPoint}/21,40>; rel=self",
            $response->headers->get('Link-self')
        );
        $this->assertSame(
            "<{$this->endPoint}/1,20>; rel=previous",
            $response->headers->get('Link-previous')
        );
        $this->assertSame(
            "<{$this->endPoint}/41,60>; rel=next",
            $response->headers->get('Link-next')
        );
    }
}
