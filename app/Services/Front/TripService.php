<?php
namespace App\Services\Front;
use App\Http\Resources\Front\Trips\TripCollection;
use App\Http\Resources\Admin\Trips\TripResource;
use App\Models\Trip;
use App\Trait\ApiResponseAble;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TripService
{
    use ApiResponseAble;
    public function index($request) : JsonResponse
    {
        try{
            $type = $request->input('type');
            $trips = Trip::query()->with('media')
                ->select('id','type','title','departure_at','duration_nights','price','price_after_discount','available_seats','booked_seats','cover_image')
                ->when($type, function ($query, $type) {
                    return $query->where('type', $type);
                })
                ->orderByDesc('id')
                ->paginate(12);
            if(!$trips->count() > 0)
                return $this->listResponse([]);
            return $this->ApiSuccessResponse(TripCollection::make($trips));
        }catch (\Exception $e)
        {
            Log::error('error for get trips ' . $e->getMessage());
            return $this->ApiErrorResponse([],'something went wrong',500);
        }
    }
    public function offers($request) : JsonResponse
    {
        try{
            $trips = Trip::query()->with('media')
                ->whereNotNull('price_after_discount')
                ->select('id','type','title','departure_at','duration_nights','price','price_after_discount','available_seats','booked_seats','cover_image')
                ->orderByDesc('id')
                ->paginate(12);
            if(!$trips->count() > 0)
                return $this->listResponse([]);
            return $this->ApiSuccessResponse(TripCollection::make($trips));
        }catch (\Exception $e)
        {
            Log::error('error for get trips offers ' . $e->getMessage());
            return $this->ApiErrorResponse([],'something went wrong',500);
        }
    }
    public function show($id) : JsonResponse
    {
        try{
            $trip = Trip::query()->find($id);
            if(!$trip)
                return $this->notFoundResponse();
            return $this->ApiSuccessResponse(TripResource::make($trip));
        }catch (\Exception $e)
        {
            Log::error('error for get trips details ' . $e->getMessage());
            return $this->ApiErrorResponse([],'something went wrong',500);
        }
    }
    public function search($request) : JsonResponse
    {
//        try{
            $lang = $request->header('lang','en');
            $query = Trip::query();
            $query->when('title', function ($q) use ($request,$lang) {
                $q->where("title->$lang",'like',"%{$request->search}%");
            });
            $query->when($request->type, fn($q) =>
                $q->where('type', $request->type)
            );

            $trips = $query->with(['media'])
                ->paginate(12);
            return $this->ApiSuccessResponse(TripCollection::make($trips),'trips retrieved successfully');
//        }catch (\Exception $e)
//        {
//            Log::error('error for get search trip ' . $e->getMessage());
//            return $this->ApiErrorResponse([],'something went wrong',500);
//        }
    }
}
