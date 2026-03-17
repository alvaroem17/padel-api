<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Services\ReservationService;
use Exception;

class ReservationController extends Controller
{
    private $ReservationService;

    public function __construct(ReservationService $ReservationService)
    {
        $this->ReservationService = $ReservationService;
    }

    public function store(StoreReservationRequest $request)
    {
        try{
            $reservation = $this->ReservationService->create(
                $request->user()->id,
                $request->court_id,
                $request->date,
                $request->start_time
            );

            return response()->json([
                'message' => 'Reservation created successfully',
                'data' => $reservation
            ], 201);

        }catch(Exception $e){
            return response()->json([
                'message' => 'Failed to create reservation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
