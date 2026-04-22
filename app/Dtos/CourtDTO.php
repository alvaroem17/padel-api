<?php

namespace App\Dtos;

use Carbon\Carbon;

class CourtDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?Carbon $createdAt = null,
        public readonly ?Carbon $updatedAt = null,
    ) {
    }

    public static function fromModel($model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            createdAt: $model->created_at,
            updatedAt: $model->updated_at,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
