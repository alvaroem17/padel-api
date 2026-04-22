<?php

namespace App\Dtos;

class AvailabilityDTO
{
    /**
     * @param array<string> $availableSlots Array de franjas horarias disponibles
     */
    public function __construct(
        public readonly int $courtId,
        public readonly string $date,
        public readonly array $availableSlots = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            courtId: $data['court_id'],
            date: $data['date'],
            availableSlots: $data['available_slots'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'court_id' => $this->courtId,
            'date' => $this->date,
            'available_slots' => $this->availableSlots,
        ];
    }
}
