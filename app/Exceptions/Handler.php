<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
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

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // 公共异常捕获，按照从上到下的顺序执行
        $this->renderable(function (HttpException $e) {
            return response()->json([
                'code' => $e->getStatusCode(),
                'message' => env('APP_DEBUG') ? $e->getMessage() . $e->getTraceAsString() : $e->getMessage(),
                'data' => null
            ]);
        });

        $this->renderable(function (Throwable $e) {
            return response()->json([
                'code' => 500,
                'message' => env('APP_DEBUG') ? $e->getMessage() . $e->getTraceAsString() : $e->getMessage(),
                'data' => null
            ]);
        });
    }
}
