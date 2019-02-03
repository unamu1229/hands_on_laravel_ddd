<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParkingCreateRequest;
use Illuminate\Http\Request;

class ParkingController extends Controller
{

    public function entry()
    {
        return view('parking.entry');
    }

    public function create(ParkingCreateRequest $parkingCreateRequest)
    {
        return redirect(route('parking.entry'));
    }
}
