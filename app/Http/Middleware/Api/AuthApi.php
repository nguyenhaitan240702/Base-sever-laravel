<?php

namespace App\Http\Middleware\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ApiHttpStatus;
use Illuminate\Contracts\Auth\Factory as Auth;

class AuthApi
{
    private $baseApi;
    protected $auth;
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
        $this->baseApi = new Controller();
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param mixed ...$guards
     * @return mixed
     *
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $message = $this->authenticate($guards);
        if (!empty($message)) {
            return $message;
        }
        $user = auth()->user();
        if (!$user) return $this->baseApi->sendError(ApiHttpStatus::HTTP_UNAUTHORIZED, trans('messages.auth.auth_expired'));
        $token = $user->currentAccessToken();
        Log::info($token);
        if ($token && Carbon::parse($token->expires_at)->isPast()) {
            $token->delete();
            return $this->baseApi->sendError(ApiHttpStatus::HTTP_UNAUTHORIZED, trans('messages.auth.auth_expired'));
        }

        return $next($request);
    }
    protected function authenticate(array $guards): ?JsonResponse
    {
        if (empty($guards)) {
            return $this->baseApi->sendError(ApiHttpStatus::HTTP_UNAUTHORIZED, trans('messages.auth.not_auth'));
        } else {
            foreach ($guards as $guard) {
                if ($this->auth->guard($guard)->check()) {
                    return $this->auth->shouldUse($guard);
                }
            }
        }
        return $this->baseApi->sendError(ApiHttpStatus::HTTP_UNAUTHORIZED, trans('messages.auth.not_auth'));
    }
}
