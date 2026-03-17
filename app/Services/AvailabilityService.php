<?php

namespace App\Services;

use App\Models\Reservation;

class AvailabilityService
{
    public function getAvailability(int $courtId, string $date): array
    {
        $slots = $this->generateSlots();

        $reservations = Reservation::where('court_id', $courtId)
            ->where('date', $date)
            ->get();

        return collect($slots)->map(function ($slot) use ($reservations) {

            $isBooked = $reservations->contains(function ($reservation) use ($slot) {
                return $reservation->start_time === $slot['start'];
            });

            return [
                'start' => $slot['start'],
                'end' => $slot['end'],
                'available' => !$isBooked
            ];
        })->values()->toArray();
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