<?php

namespace App\Rules;

use Domain\Exception\DomainException;
use Domain\Model\ValueObject\ParkingId;
use Domain\Model\ValueObject\ParkingPrice;
use Illuminate\Contracts\Validation\Rule;

class Parking implements Rule
{
    private $massage;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $parking = new \Domain\Model\Entity\Parking(new ParkingId(null));
        $parking->setPriceDay(new ParkingPrice(request()->price_day));

        try {
            $parking->setPriceTime(new ParkingPrice($value));
        } catch (DomainException $e) {
            $this->massage = $e->getMessage();

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->massage;
    }
}
