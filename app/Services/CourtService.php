<?php

namespace App\Services;

use App\Dtos\CourtDTO;
use App\Models\Court;
use Exception;

class CourtService
{
    /**
     * Obtener todas las canchas con paginación
     *
     * @param int $paginate
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll(int $paginate = 10)
    {
        return Court::query()
            ->paginate($paginate)
            ->through(fn($court) => CourtDTO::fromModel($court));
    }

    /**
     * Obtener una cancha por ID
     *
     * @param int $courtId
     * @return CourtDTO
     * @throws Exception
     */
    public function getById(int $courtId): CourtDTO
    {
        $court = Court::query()->find($courtId);

        if (!$court) {
            throw new Exception('Court not found');
        }

        return CourtDTO::fromModel($court);
    }

    /**
     * Crear una nueva cancha
     *
     * @param string $name
     * @return CourtDTO
     */
    public function create(string $name): CourtDTO
    {
        $court = Court::create([
            'name' => $name,
        ]);

        return CourtDTO::fromModel($court);
    }

    /**
     * Actualizar una cancha
     *
     * @param int $courtId
     * @param string $name
     * @return CourtDTO
     * @throws Exception
     */
    public function update(int $courtId, string $name): CourtDTO
    {
        $court = Court::query()->find($courtId);

        if (!$court) {
            throw new Exception('Court not found');
        }

        $court->update([
            'name' => $name,
        ]);

        return CourtDTO::fromModel($court);
    }

    /**
     * Eliminar una cancha
     *
     * @param int $courtId
     * @return bool
     * @throws Exception
     */
    public function delete(int $courtId): bool
    {
        $court = Court::query()->find($courtId);

        if (!$court) {
            throw new Exception('Court not found');
        }

        return $court->delete($courtId);
    }
}
