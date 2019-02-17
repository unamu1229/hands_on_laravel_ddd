<?php

namespace Tests\Unit;

use App\Events\OrderShipped;
use Domain\Model\Entity\Parking;
use Domain\Model\ValueObject\ParkingId;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        event(new OrderShipped(new Parking(new ParkingId(uniqid()))));
        $this->assertTrue(true);
    }
}
