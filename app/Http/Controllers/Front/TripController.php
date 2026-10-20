<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\TripService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function __construct(protected TripService $tripService){}
    public function index(Request $request) : JsonResponse
    {
        return $this->tripService->index($request);
    }
    public function offers(Request $request) : JsonResponse
    {
        return $this->tripService->offers($request);
    }
    public function show($id) : JsonResponse
    {
        return $this->tripService->show($id);
    }
    public function search(Request $request) : JsonResponse
    {
        return $this->tripService->search($request);
    }
}
