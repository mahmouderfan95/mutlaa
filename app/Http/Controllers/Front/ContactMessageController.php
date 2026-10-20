<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ContactMessages\StoreRequest;
use App\Services\Front\ContactMessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function __construct(protected ContactMessageService $contactMessageService){}
    public function store(StoreRequest $request) : JsonResponse
    {
        return $this->contactMessageService->store($request);
    }
}
