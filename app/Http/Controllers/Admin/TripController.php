<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Trips\StoreRequest;
use App\Http\Requests\Admin\Trips\UpdateRequest;
use App\Http\Resources\Admin\Trips\TripCollection;
use App\Http\Resources\Admin\Trips\TripResource;
use App\Services\Admin\TripService;
use App\Trait\ApiResponseAble;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TripController extends Controller
{
    use ApiResponseAble;
    public function __construct(protected TripService $service){}
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['status', 'search']);
        $perPage = (int) $request->get('per_page', 15);

        $trips = $this->service->list($filters, $perPage);

        return $this->ApiSuccessResponse(TripCollection::make($trips));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $trip = $this->service->store($request->validated());

        return $this->ApiSuccessResponse(new TripResource($trip));
    }
    public function show(int $id): JsonResponse
    {
        $trip = $this->service->find($id);

        return $this->ApiSuccessResponse(new TripResource($trip));
    }

    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $trip = $this->service->update($id, $request->validated());

        return $this->ApiSuccessResponse(new TripResource($trip));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->ApiSuccessResponse([],__('messages.deleted_successfully'));
    }
}
