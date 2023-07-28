<?php

namespace App\Http\Controllers;

use App\Helpers\Email\SendMail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function sendResponse($result, $message, $code = HttpResponse::HTTP_OK): JsonResponse
    {
        return Response::json(self::makeResponse($message, $result), $code);
    }

    public function sendError($err_code, $message, $error = [], $code = HttpResponse::HTTP_BAD_REQUEST): JsonResponse
    {
        return Response::json(self::makeError($err_code, $message, $error), $code);
    }

    private function makeResponse($message, $data): array
    {
        return [
            'status' => 200,
            'success' => true,
            'message' => $message,
            'data' => $data
        ];
    }
    private function makeError($err_code, $message, $error): array
    {
        $res = [
            'status' => $err_code,
            'success' => false,
            'message' => $message,
        ];
        if (!empty($error)) {
            $res['error'] = $error;
        }
        return $res;
    }

    public function handleException($error): JsonResponse
    {
        return $this->sendError(HttpResponse::HTTP_BAD_REQUEST, trans('messages.error_message'), $error->getMessage(), HttpResponse::HTTP_BAD_REQUEST);
    }
}
