<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourtResource;
use App\Models\Court;
use Illuminate\Http\Request;
use App\Services\AvailabilityService;
use App\Services\CourtService;

class CourtController extends Controller
{   
    private $courtService;
    private $availabilityService;

    public function __construct(CourtService $courtService, AvailabilityService $availabilityService)
    {
        $this->courtService = $courtService;
        $this->availabilityService = $availabilityService;
    }

    public function index(Request $request)
    {
        $paginate = $request->query('paginate', 10);
        $courts = $this->courtService->getAll($paginate);
        return CourtResource::collection($courts);
    }

    public function availability(Court $court, Request $request)
    {
        $date = $request->query('date');

        if (!$date) {
            return response()->json([
                'message' => 'date is required'
            ], 422);
        }

        try {
            // Obtener disponibilidad usando DTO
            $availabilityDTO = $this->availabilityService->getAvailability($court->id, $date);

            return response()->json([
                'data' => $availabilityDTO->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $courtDTO = $this->courtService->create($validatedData['name']);

            return response()->json([
                'data' => $courtDTO->toArray()
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function show(Court $court)
    {
        try {
            $courtDTO = $this->courtService->getById($court->id);

            return response()->json([
                'data' => $courtDTO->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, Court $court)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $courtDTO = $this->courtService->update($court->id, $validatedData['name']);

            return response()->json([
                'data' => $courtDTO->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy(Court $court)
    {
        try {
            $this->courtService->delete($court->id);

            return response()->json([
                'message' => 'Court deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
