<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
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
            'day'  => ['required', 'date'],
            'hour' => ['required', 'date_format:H:i'],
        ]);

        $day = Carbon::parse($validated['day'])->startOfDay();
        if ($day->lt(Carbon::today())) {
            return back()->withErrors(['day' => 'You cannot select a past date.'])->withInput();
        }

        $time = Carbon::createFromFormat('H:i', $validated['hour']);
        $minutes = $time->hour * 60 + $time->minute;
        if ($minutes < 10 * 60 || $minutes > 22 * 60) {
            return back()->withErrors(['hour' => 'Time must be between 10:00 and 22:00.'])->withInput();
        }

        if ($day->isSameDay(Carbon::today())) {
            $selected = Carbon::createFromFormat('Y-m-d H:i', $validated['day'].' '.$validated['hour']);
            if ($selected->lt(Carbon::now())) {
                return back()->withErrors(['hour' => 'You cannot select a time in the past (for today).'])->withInput();
            }
        }

        $picturePath = null;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('reservations', 'public');
        }

        Reservation::create([
            'name' => $validated['name'],
            'gmail' => $validated['gmail'],
            'phone' => $validated['phone'],
            'picture_path' => $picturePath,
            'people' => $validated['people'],
            'day' => $validated['day'],
            'hour' => $validated['hour'],
        ]);

        return redirect()->route('reservation.create')->with('success', 'Reservation submitted!');
    }
}

