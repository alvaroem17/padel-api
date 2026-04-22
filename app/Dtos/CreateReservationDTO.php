<?php

namespace App\Dtos;

class CreateReservationDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly int $courtId,
        public readonly string $date,
        public readonly string $startTime,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            userId: $data['user_id'],
            courtId: $data['court_id'],
            date: $data['date'],
            startTime: $data['start_time'],
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'court_id' => $this->courtId,
            'date' => $this->date,
            'start_time' => $this->startTime,
        ];
    }
}
