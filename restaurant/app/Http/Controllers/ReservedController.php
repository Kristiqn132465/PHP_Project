<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReservedController extends Controller
{
    public function index(Request $request)
    {
        $selectedDay = $request->input('day', now()->toDateString());
        $ahead = $request->boolean('ahead');

        $query = Reservation::query()->orderBy('day')->orderBy('hour');

        if ($ahead) {
            $query->whereBetween('day', [
                $selectedDay,
                now()->parse($selectedDay)->addDays(3)->toDateString()
            ]);
        } else {
            $query->whereDate('day', $selectedDay);
        }

        $reservations = $query->get();

        return view('reserved.index', compact('reservations', 'selectedDay', 'ahead'));
    }

    public function edit(Reservation $reservation)
    {
        return view('reserved.index', compact('reservations', 'selectedDay', 'ahead'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'gmail' => ['required','email','max:255'],
            'phone' => ['required','string','max:50'],
            'people' => ['required','integer','min:1'],
            'day' => ['required','date'],
            'hour' => ['required'],
            'picture' => ['nullable','image','max:2048'],
        ]);

        if ($request->hasFile('picture')) {
            if ($reservation->picture_path) {
                Storage::disk('public')->delete($reservation->picture_path);
            }
            $data['picture_path'] = $request->file('picture')->store('reservations', 'public');
        }

        unset($data['picture']);

        $reservation->update($data);

        return redirect()->route('reserved.index')->with('success', 'Reservation updated.');
    }

    public function destroy(Reservation $reservation)
    {
        if ($reservation->picture_path) {
            Storage::disk('public')->delete($reservation->picture_path);
        }

        $reservation->delete();

        return redirect()->route('reserved.index')->with('success', 'Reservation deleted.');
    }
}
