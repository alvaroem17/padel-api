<?php

namespace App\Services;

use App\Dtos\AvailabilityDTO;
use App\Models\Reservation;

class AvailabilityService
{
    /**
     * Obtener disponibilidad de una cancha para una fecha específica
     *
     * @param int $courtId
     * @param string $date Formato: YYYY-MM-DD
     * @return AvailabilityDTO
     */
    public function getAvailability(int $courtId, string $date): AvailabilityDTO
    {
        $slots = $this->generateSlots();

        $reservations = Reservation::query()->where('court_id', $courtId)
            ->where('date', $date)
            ->get();

            $availableSlots = collect($slots)
                ->filter(function ($slot) use ($reservations) {
                $isBooked = $reservations->contains(function ($reservation) use ($slot) {
                    return $reservation->start_time === $slot['start'];
                });
                
                return !$isBooked;
            })
            ->map(fn($slot) => $slot['start'])
            ->values()
            ->toArray();

        return new AvailabilityDTO(
            courtId: $courtId,
            date: $date,
            availableSlots: $availableSlots
        );
    }

    private function generateSlots(): array
    {
        $slots = [];

        $start = strtotime('08:00');
        $end = strtotime('23:00');

        while ($start < $end) {

            $slotEnd = strtotime('+90 minutes', $start);

            if ($slotEnd > $end) {
                break;
            }

            $slots[] = [
                'start' => date('H:i', $start),
                'end' => date('H:i', $slotEnd),
            ];

            $start = $slotEnd;
        }

        return $slots;
    }
}