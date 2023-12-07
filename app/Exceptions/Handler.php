<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    // public function register()
    // {
    //     $this->reportable(function (Throwable $e) {
    //         //
    //     });
    // }

    public function render($request, Throwable $e)
    {
        return parent::render($request, $exception);
         if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError('Resource not found');
        } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError('Endpoint not found');
        }
    
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondWithError($e->getMessage());
    }

    // public function register()
    // {
    //     $this->renderable(function (MethodNotAllowedHttpException $e) {
    //         return response()->json(['error' => 'Method Not Allowed', 'success' => false, 'message' => $e->getMessage()], SymfonyResponse::HTTP_METHOD_NOT_ALLOWED);
    //     });
    
    //     $this->renderable(function (NotFoundHttpException $e) {
    //         return response()->json(['error' => 'Http NotFound', 'success' => false, 'message' => $e->getMessage()], SymfonyResponse::HTTP_NOT_FOUND);
    //     });
    
    //     $this->renderable(function (UnauthorizedException $e) {
    //         return response()->json(['error' => 'You do not have the required authorization.', 'success' => false, 'message' => $e->getMessage()], 403);
    //     });
    
    //     $this->renderable(function (BadMethodCallException $e) {
    //         return response()->json(['error' => 'Bad Method Call Exception', 'success' => false, 'message' => $e->getMessage()], 403);
    //     });
    // }
}
