<?php

namespace App\Dtos;

use Carbon\Carbon;

class ReservationDTO
{
    public function __construct(
        public readonly int $id,
        public readonly int $userId,
        public readonly int $courtId,
        public readonly string $date,
        public readonly string $startTime,
        public readonly ?string $endTime = null,
        public readonly ?Carbon $createdAt = null,
        public readonly ?Carbon $updatedAt = null,
    ) {
    }

    public static function fromModel($model): self
    {
        return new self(
            id: $model->id,
            userId: $model->user_id,
            courtId: $model->court_id,
            date: $model->date,
            startTime: $model->start_time,
            endTime: $model->end_time ?? null,
            createdAt: $model->created_at,
            updatedAt: $model->updated_at,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'court_id' => $this->courtId,
            'date' => $this->date,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
