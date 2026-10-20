<?php
namespace App\Services\Front;
use App\Models\ContactMessage;
use App\Notifications\ContactUsNotification;
use App\Trait\ApiResponseAble;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ContactMessageService
{
    use ApiResponseAble;
    public function store($request) : JsonResponse
    {
        DB::beginTransaction();
        $contactMessage = ContactMessage::query()->create(
            $request->validated()
        );
        try{
            Notification::route(
                'mail',
                'reservations@mutlaatravel.com'
            )->notify(
                new ContactUsNotification($contactMessage)
            );
            DB::commit();
            return $this->ApiSuccessResponse([],'تم ارسال الرسالة بنجاح');
        }catch (\Exception $exception)
        {
            DB::rollBack();
            Log::error('error for get create contact message ' . $exception->getMessage());
            return $this->ApiErrorResponse([],'something went wrong',500);
        }
    }
}
