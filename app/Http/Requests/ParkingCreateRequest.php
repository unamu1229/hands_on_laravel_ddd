<?php

namespace App\Http\Requests;

use App\Rules\Parking;
use Illuminate\Foundation\Http\FormRequest;

class ParkingCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price_day' => 'required',
            'price_time' => ['required', new Parking()]
        ];
    }

}
