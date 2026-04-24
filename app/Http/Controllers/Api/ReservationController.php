<?php

namespace App\Http\Controllers\Api;

use App\Dtos\CreateReservationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Traits\ApiResponse;
use App\Services\ReservationService;
use Exception;

class ReservationController extends Controller
{
    use ApiResponse;

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

            return $this->successResponse($reservationDTO->toArray(), 'Reservation created successfully', 201);

        } catch (Exception $e) {
            return $this->errorResponse('Failed to create reservation', 500, $e->getMessage());
        }
    }

}
