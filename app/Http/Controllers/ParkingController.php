<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParkingCreateRequest;
use Illuminate\Http\Request;
use App\Jobs\ProcessPodcast;

class ParkingController extends Controller
{

    public function entry()
    {
        return view('parking.entry');
    }

    public function create(ParkingCreateRequest $parkingCreateRequest)
    {
        ProcessPodcast::dispatch($parkingCreateRequest->price_day);
     //   $this->dispatch(new ProcessPodcast($parkingCreateRequest->price_day));
        return redirect(route('parking.entry'));
    }
}
