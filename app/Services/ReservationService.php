<?php

namespace App\Services;

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

    public function create(int $userId, int $courtId, string $date, string $startTime): Reservation
    {
        // 1. Validar slot válido
        if (!in_array($startTime, $this->validSlots)) {
            throw new Exception("Invalid time slot");
        }

        // 2. Comprobar si ya está reservado
        $exists = Reservation::where('court_id', $courtId)
            ->where('date', $date)
            ->where('start_time', $startTime)
            ->exists();

        if ($exists) {
            throw new Exception("Slot already booked");
        }

        // 3. Calcular end_time
        $endTime = Carbon::parse($startTime)->addMinutes(90)->format('H:i');

        // 4. Crear reserva
        return Reservation::create([
            'user_id' => $userId,
            'court_id' => $courtId,
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
    }
}
