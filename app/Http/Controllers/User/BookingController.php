<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Cars;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $car = Cars::findOrFail($validated['car_id']);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_days' => Carbon::parse($validated['start_date'])->diffInDays($validated['end_date']),
            'total_price' => $this->calculateTotalPrice($car, $validated['start_date'], $validated['end_date']),
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Booking berhasil dibuat',
            'booking' => $booking,
            'next_step' => route('payment.create', $booking->id)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function calculateTotalPrice($car, $startDate, $endDate)
    {
        $days = Carbon::parse($startDate)->diffInDays($endDate);
        return $days * $car->rental_price;
    }
}
