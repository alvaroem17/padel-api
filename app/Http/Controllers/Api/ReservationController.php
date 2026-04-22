<?php

namespace App\Http\Controllers\Api;

use App\Dtos\CreateReservationDTO;
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
        try {
            // Convertir request a DTO
            $createReservationDTO = CreateReservationDTO::fromArray([
                'user_id' => $request->user()->id,
                'court_id' => $request->court_id,
                'date' => $request->date,
                'start_time' => $request->start_time,
            ]);

            // Pasar DTO al servicio
            $reservationDTO = $this->ReservationService->create($createReservationDTO);

            return response()->json([
                'message' => 'Reservation created successfully',
                'data' => $reservationDTO->toArray()
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create reservation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
