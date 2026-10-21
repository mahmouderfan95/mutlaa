<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Orders\OrderCollection;
use App\Http\Resources\Admin\Orders\OrderResource;
use App\Services\Admin\OrderService;
use App\Trait\ApiResponseAble;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponseAble;
    public function __construct(protected OrderService $service){}
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['status', 'search']);
        $perPage = (int) $request->get('per_page', 15);

        $trips = $this->service->list($filters, $perPage);

        return $this->ApiSuccessResponse(OrderCollection::make($trips));
    }
    public function show(int $id): JsonResponse
    {
        $trip = $this->service->find($id);

        return $this->ApiSuccessResponse(new OrderResource($trip));
    }
}
