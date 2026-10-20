<?php

namespace App\Exceptions;

use App\Trait\ApiResponseAble;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthenticationFailedException extends Exception
{
    use ApiResponseAble;
    public function __construct(string $message = 'بيانات الدخول غير صحيحة')
    {
        parent::__construct($message);
    }
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
        ], 401);
    }
}
