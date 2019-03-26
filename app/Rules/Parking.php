<?php

namespace App\Rules;

use src\Domain\Model\ValueObject\ParkingId;
use src\Domain\Model\ValueObject\ParkingPrice;
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

        if ($parking->getPriceDay() == null) {
            $this->massage = '時間貸しの料金のみを設定することはできません';
            return false;
        }

        if ($parking->IsValidPriceTime(new ParkingPrice($value))) {
            $this->massage = '時間貸しは割高にするようにして下さい';
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
