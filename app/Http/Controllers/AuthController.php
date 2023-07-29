<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Queues\PTApiLoginEvent;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->validated();
            if (Auth::attempt($credentials,true)) {
                $user = Auth::user();
                if (!$user->active) {
                    return $this->sendError(HttpResponse::HTTP_NOT_ACCEPTABLE, trans('messages.auth.err_account_not_accepted'), array(), HttpResponse::HTTP_NOT_ACCEPTABLE);
                }

                event(new PTApiLoginEvent($user->id, 1));
                $expirationTime = Carbon::now()->addDays(1);
                $token = $user->createToken('API Token');
                $token->accessToken->expires_at = $expirationTime;
                $token->accessToken->save();

                $result = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'status' => $user->status,
                    'language' => $user->language,
                    'token' => $token->plainTextToken,
                    'expires_at' => $expirationTime,
                ];
                return $this->sendResponse($result, trans('messages.auth.auth_success'));
            } else {
                return $this->sendError(HttpResponse::HTTP_INSUFFICIENT_STORAGE, trans('messages.auth.err_wrong_account'), array(), HttpResponse::HTTP_INSUFFICIENT_STORAGE);
            }
        } catch (\Exception $e) {
            Log::error("[AuthController][login] cause:  " . $e->getMessage() . ' line: ' . $e->getLine());
            return $this->handleException($e);
        }
    }
    public function logout(): JsonResponse
    {
        try {
            $user = Auth::user();
            event(new PTApiLoginEvent($user->id, 0));
            return $this->sendResponse([],"success");
        } catch (\Exception $e) {
            Log::error("[AuthController][logout] cause:  " . $e->getMessage() . ' line: ' . $e->getLine());
            return $this->handleException($e);
        }
    }
}
