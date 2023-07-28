<?php

namespace App\Exceptions;

use HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Sentry\Laravel\Integration;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
    public function report(Throwable $e)
    {
        if ($this->shouldReport($e) && app()->bound('sentry')) {
            Integration::captureUnhandledException($e);
        }
        parent::report($e);
    }
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {
            return $this->renderJsonException($e);
        }

        return parent::render($request, $e);
    }
    protected function renderJsonException(Throwable $e): JsonResponse
    {
        $statusCode = 500;
        if ($e instanceof HttpException) {
            $statusCode = $e->getCode();
        }
        $message = 'Something went wrong';
        $errorMes = $e->getMessage() ?: 'Something went wrong';
        $error = [
            'status' => $statusCode,
            'success' => false,
            'message' => $message,
            'error' => $errorMes,
        ];
        return new JsonResponse(['error' => $error], $statusCode);
    }
}
