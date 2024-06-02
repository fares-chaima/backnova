<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;
use Exception;


class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // catch 405 errors and show JSON response instead
        $this->renderable(function(MethodNotAllowedHttpException $e){
            return response()->json([
                'error' => 'This method is not allowed, Try other.'
            ], 405); 
        });

        
        $this->renderable(function(NotFoundHttpException $e){
            return response()->json([
                'error' => 'The url you\'re trying to access is not available on this server.'
            ], 404);
        }); 

        $this->renderable((function(ValidationException $e){
            return response()->json([
                'error' => $e->errors()
            ], 422);
        }));

       
    }
}
