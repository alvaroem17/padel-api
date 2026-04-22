<?php

namespace App\Services;

use App\Dtos\CreateReservationDTO;
use App\Dtos\ReservationDTO;
use App\Models\Reservation;
use Carbon\Carbon;
use Exception;

class ReservationService
{
   private $validSlots = [
        '08:00', '09:30', '11:00', '12:30',
        '14:00', '15:30', '17:00', '18:30',
        '20:00', '21:30'
    ];

    /**
     * Crear una nueva reserva desde un DTO
     *
     * @param CreateReservationDTO $dto
     * @return ReservationDTO
     * @throws Exception
     */
    public function create(CreateReservationDTO $dto): ReservationDTO
    {
        // 1. Validar slot válido
        if (!in_array($dto->startTime, $this->validSlots)) {
            throw new Exception("Invalid time slot");
        }

        // 2. Comprobar si ya está reservado
        $exists = Reservation::query()
            ->where('court_id', $dto->courtId)
            ->where('date', $dto->date)
            ->where('start_time', $dto->startTime)
            ->exists();

        if ($exists) {
            throw new Exception("Slot already booked");
        }

        // 3. Calcular end_time
        $endTime = Carbon::parse($dto->startTime)->addMinutes(90)->format('H:i');

        // 4. Crear reserva
        $reservation = Reservation::create([
            'user_id' => $dto->userId,
            'court_id' => $dto->courtId,
            'date' => $dto->date,
            'start_time' => $dto->startTime,
            'end_time' => $endTime,
        ]);

        return ReservationDTO::fromModel($reservation);
    }
}
