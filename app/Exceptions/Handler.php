<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

        // Api Exception Response
        $this->renderable(function (Exception $e, $request) {
            if ($request->is('api/*')) {
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = __('messages.internal_server_error');

                if ($e instanceof AuthenticationException) {
                    $statusCode = Response::HTTP_UNAUTHORIZED;
                    $message = $e->getMessage() ?? __('messages.unauthorized');
                } else if ($e instanceof NotFoundHttpException) {
                    $statusCode = Response::HTTP_NOT_FOUND;
                    $message = __('messages.not_found');
                } else if ($e instanceof MethodNotAllowedHttpException) {
                    $statusCode = Response::HTTP_METHOD_NOT_ALLOWED;
                    $message = __('messages.method_not_allowed');
                } else if ($e instanceof HttpException) {
                    $statusCode = $e->getStatusCode();
                    $message = $e->getMessage();
                }

                return response()->json([
                    'status' => 'error',
                    'message' => $message,
                ], $statusCode);
            }
        });
    }
}
