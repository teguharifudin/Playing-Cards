<?php

namespace App\Http\Controllers;

use App\Services\CardDistributionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardDistributionController extends Controller
{
    private CardDistributionService $cardService;

    public function __construct(CardDistributionService $cardService)
    {
        $this->cardService = $cardService;
    }
    
    public function distribute(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'numPeople' => 'required|integer|min:1'
            ]);

            $distribution = $this->cardService->distribute($request->input('numPeople'));

            return response()->json([
                'status' => 'success',
                'data' => $distribution
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
