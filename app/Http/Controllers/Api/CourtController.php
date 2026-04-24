<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourtResource;
use App\Http\Traits\ApiResponse;
use App\Models\Court;
use Illuminate\Http\Request;
use App\Services\AvailabilityService;
use App\Services\CourtService;

class CourtController extends Controller
{
    use ApiResponse;

    private $courtService;
    private $availabilityService;

    public function __construct(CourtService $courtService, AvailabilityService $availabilityService)
    {
        $this->courtService = $courtService;
        $this->availabilityService = $availabilityService;
    }

    public function index(Request $request)
    {
        try {
            $paginate = $request->query('paginate', 10);
            $courts = $this->courtService->getAll($paginate);
            return $this->paginatedResponse($courts);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function availability(Court $court, Request $request)
    {
        $date = $request->query('date');

        if (!$date) {
            return $this->errorResponse('date is required', 422);
        }

        try {
            // Obtener disponibilidad usando DTO
            $availabilityDTO = $this->availabilityService->getAvailability($court->id, $date);

            return $this->successResponse($availabilityDTO->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $courtDTO = $this->courtService->create($validatedData['name']);

            return $this->successResponse($courtDTO->toArray(), 'Created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function show(Court $court)
    {
        try {
            $courtDTO = $this->courtService->getById($court->id);

            return $this->successResponse($courtDTO->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function update(Request $request, Court $court)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $courtDTO = $this->courtService->update($court->id, $validatedData['name']);

            return $this->successResponse($courtDTO->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function destroy(Court $court)
    {
        try {
            $this->courtService->delete($court->id);

            return $this->successResponse(null, 'Court deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}
