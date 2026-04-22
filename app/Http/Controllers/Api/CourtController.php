<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourtResource;
use App\Models\Court;
use Illuminate\Http\Request;
use App\Services\AvailabilityService;

class CourtController extends Controller
{   
    private $availabilityService;

    public function __construct(AvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    public function index(int $paginate = 10)
    {
        $courts = Court::query()->paginate($paginate);
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

        // Obtener disponibilidad usando DTO
        $availabilityDTO = $this->availabilityService->getAvailability($court->id, $date);

        return response()->json([
            'data' => $availabilityDTO->toArray()
        ]);
    }
}
