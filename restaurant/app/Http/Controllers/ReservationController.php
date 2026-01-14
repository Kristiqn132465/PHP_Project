<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create()
    {
        return view('reservation.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'min:2', 'max:80'],
        'gmail' => ['required', 'email', 'max:255'],
        'phone' => ['required', 'string', 'min:6', 'max:25'],

        'picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

        'people' => ['required', 'integer', 'min:1', 'max:50'],

        // date + time
        'day'  => ['required', 'date'],
        'hour' => ['required', 'date_format:H:i'],
    ]);

    // --- Custom restrictions ---
    // 1) No past dates
    $day = Carbon::parse($validated['day'])->startOfDay();
    $today = Carbon::today();

    if ($day->lt($today)) {
        return back()
            ->withErrors(['day' => 'You cannot select a past date.'])
            ->withInput();
    }

    // 2) Only between 10:00 and 22:00 (inclusive)
    $time = Carbon::createFromFormat('H:i', $validated['hour']);
    $minutes = $time->hour * 60 + $time->minute;

    $min = 10 * 60; // 10:00
    $max = 22 * 60; // 22:00

    if ($minutes < $min || $minutes > $max) {
        return back()
            ->withErrors(['hour' => 'Time must be between 10:00 and 22:00.'])
            ->withInput();
    }

    // 3) If the day is today, the time must not be in the past
    if ($day->isSameDay($today)) {
        $selected = Carbon::createFromFormat('Y-m-d H:i', $validated['day'].' '.$validated['hour']);
        if ($selected->lt(Carbon::now())) {
            return back()
                ->withErrors(['hour' => 'You cannot select a time in the past (for today).'])
                ->withInput();
        }
    }

    // Store picture if provided
    if ($request->hasFile('picture')) {
        $validated['picture'] = $request->file('picture')->store('reservations', 'public');
    }

    return back()->with('success', 'Reservation submitted!');
}

}
