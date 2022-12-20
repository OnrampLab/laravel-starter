<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     */
    public function report(\Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render(Request $request, \Throwable $exception): Response
    {
        if (strpos($request->header('Content-Type'), 'application/json') !== false) {
            $status = 500;

            if ($this->isHttpException($exception)) {
                // Grab the HTTP status code from the Exception
                $status = $exception->getStatusCode();
            }

            if ($exception instanceof AuthenticationException || $exception instanceof JWTException) {
                $status = 401;
            }

            $message = $exception->getMessage();

            if ($exception instanceof NotFoundHttpException) {
                $message = 'Route not found';
            }

            Log::error("[Handler] {$message}", [
                'url' => $request->fullUrl(),
                'data' => $request->except(['password']),
                'exception' => $exception,
            ]);

            return response()->json([
                'message' => $message,
            ], $status);
        }
        if ($this->isHttpException($exception)) {
            return $this->renderHttpException($exception);
        }

        return parent::render($request, $exception);
    }
}
