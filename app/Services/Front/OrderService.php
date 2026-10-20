<?php
namespace App\Services\Front;
use App\Models\Order;
use App\Trait\ApiResponseAble;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class OrderService
{
    use ApiResponseAble;
    public function store($request) : JsonResponse
    {
        try{
            $data = $request->validated();
            $createOrder = Order::query()->create($data);
            return $this->ApiSuccessResponse($createOrder,'created reservation successfully');
        }catch (\Exception $exception)
        {
            Log::error('error for get create order ' . $exception->getMessage());
            return $this->ApiErrorResponse([],'something went wrong',500);
        }
    }
}
