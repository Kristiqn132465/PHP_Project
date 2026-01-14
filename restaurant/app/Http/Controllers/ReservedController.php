<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservedController extends Controller
{
    public function index(Request $request)
    {
        $selectedDay = $request->input('day', Carbon::today()->toDateString());

        $ahead = $request->boolean('ahead', false);
        $start = Carbon::parse($selectedDay)->startOfDay();
        $end = $ahead ? (clone $start)->addDays(3)->endOfDay() : (clone $start)->endOfDay();

        $reservations = Reservation::query()
            ->whereBetween('day', [$start->toDateString(), $end->toDateString()])
            ->orderBy('day')
            ->orderBy('hour')
            ->get();

        return view('reserved.index', [
            'selectedDay' => $selectedDay,
            'ahead' => $ahead,
            'reservations' => $reservations,
        ]);
    }
}
