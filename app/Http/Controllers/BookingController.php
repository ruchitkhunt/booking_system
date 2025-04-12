<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Validation\ValidatesRequests;


class BookingController extends Controller
{
    use ValidatesRequests;
    public function index()
    {
        $bookings = Booking::latest()->paginate(15);
        return view('dashboard', compact('bookings'));
    }

    public function create()
    {
        return view('bookings.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'booking_date' => 'required|date',
            'booking_type' => 'required|in:full_day,half_day,custom',
            'booking_slot' => 'nullable|required_if:booking_type,half_day|in:first_half,second_half',
            'booking_from' => 'nullable|required_if:booking_type,custom|date_format:H:i',
            'booking_to' => 'nullable|required_if:booking_type,custom|date_format:H:i|after:booking_from',
        ]);

        if ($this->hasConflict($request)) {
            throw ValidationException::withMessages(['booking_date' => 'Conflicting booking exists for the given date and time.']);
        }

        Booking::create($request->all());
        return redirect()->route('dashboard')->with('success', 'Booking created successfully.');
    }

    public function edit(Booking $booking)
    {
        return view('bookings.create', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'booking_date' => 'required|date',
            'booking_type' => 'required|in:full_day,half_day,custom',
            'booking_slot' => 'nullable|required_if:booking_type,half_day|in:first_half,second_half',
            'booking_from' => 'nullable|required_if:booking_type,custom|date_format:H:i',
            'booking_to' => 'nullable|required_if:booking_type,custom|date_format:H:i|after:booking_from',
        ]);

        if ($this->hasConflict($request, $booking->id)) {
            throw ValidationException::withMessages(['booking_date' => 'Conflicting booking exists.']);
        }

        $booking->update($request->all());
        return redirect()->route('dashboard')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('dashboard')->with('success', 'Booking deleted successfully.');
    }

    protected function hasConflict($request, $excludeId = null)
    {
        $query = Booking::where('booking_date', $request->booking_date);
        if ($excludeId) $query->where('id', '!=', $excludeId);

        $bookings = $query->get();

        foreach ($bookings as $existing) {
            if ($request->booking_type === 'full_day') return true;

            if ($request->booking_type === 'half_day') {
                if ($existing->booking_type === 'full_day') return true;
                if ($existing->booking_type === 'half_day' && $existing->booking_slot === $request->booking_slot) return true;

                if ($existing->booking_type === 'custom' && $this->timeConflict(
                    $existing->booking_from,
                    $existing->booking_to,
                    $request->booking_slot === 'first_half' ? '09:00' : '13:00',
                    $request->booking_slot === 'first_half' ? '12:00' : '17:00'
                )) return true;
            }

            if ($request->booking_type === 'custom') {
                if ($existing->booking_type === 'full_day') return true;

                if ($existing->booking_type === 'half_day') {
                    $slotTime = $existing->booking_slot === 'first_half' ? ['09:00', '12:00'] : ['13:00', '17:00'];
                    if ($this->timeConflict($request->booking_from, $request->booking_to, ...$slotTime)) return true;
                }

                if ($existing->booking_type === 'custom') {
                    if ($this->timeConflict($request->booking_from, $request->booking_to, $existing->booking_from, $existing->booking_to)) return true;
                }
            }
        }

        return false;
    }

    protected function timeConflict($start1, $end1, $start2, $end2)
    {
        return !($end1 <= $start2 || $start1 >= $end2);
    }
}
