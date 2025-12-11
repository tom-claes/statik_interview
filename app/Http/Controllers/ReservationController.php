<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        // Validate the request data
        $data = $request->validated();

        // Retrieve amount of existing reservations for the selected date and timeslot
        $amount_of_existing_reservations = Reservation::where('reservation_date', $data['reservation_date'])
            ->where('reservation_timeslot', $data['reservation_timeslot'])
            ->count();
        

        // Determine how many new reservations are being submitted
        $newReservations = 0;
        for ($i = 1; $i <= 3; $i++) {
            if (!empty($data["firstname{$i}"]) && !empty($data["lastname{$i}"])) {
                $newReservations++;
            }
        }

        // Check if adding the new reservations would exceed the limit of 200
        if($amount_of_existing_reservations + $newReservations > 200) {
            return redirect()->back()->withInput()->withErrors(['main_error' => 'Het geselecteerde tijdslot is volgeboekt. Kies een ander tijdslot of een andere datum.']);
        }

        try{
            // Begin db transaction
            \DB::beginTransaction();
            // Create reservations for each visitor
            for ($i = 1; $i <= 3; $i++) {
                if (!empty($data["firstname{$i}"]) && !empty($data["lastname{$i}"])) {
                    Reservation::create([
                        'firstname' => ucwords(strtolower($data["firstname{$i}"])),
                        'lastname' => ucwords(strtolower($data["lastname{$i}"])),
                        'reservation_date' => $data['reservation_date'],
                        'reservation_timeslot' => $data['reservation_timeslot'],
                        'subscription_number' => $data["subscription_number{$i}"] ?? null,
                    ]);
                }
            }
            // Commit transaction
            \DB::commit();
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error creating store', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->withInput()->withErrors(['main_error' => 'Er is een fout opgetreden bij het opslaan van de reservering. Probeer het later opnieuw.']);
        }

        return view('reservation_success', ['reservationData' => $data]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
