<?php

namespace Ora\Chat\Exceptions;

use Exception;
use Ora\Chat\Exceptions\StorageValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException)
        {
            return response()->payload(['error' => 'token_expired'], false, $e->getStatusCode());
        }
        elseif ($e instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException)
        {
            return response()->payload(['error' => 'token_invalid'], false, $e->getStatusCode());
        }
        elseif ($e instanceof Tymon\JWTAuth\Exceptions\JWTException)
        {
            return response()->payload(['error' => 'token_absent'], false, $e->getStatusCode());
        }
        elseif ($e instanceof StorageValidationException)
        {
            return response()->payload(['error' => $e->errors()], false, $e->getStatusCode());
        }
        else
        {
            return response()->payload([(string) $e], false, $e->getStatusCode());
        }

        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->payload(['error' => 'Unauthenticated.'], false, 401);
        }

        return redirect()->guest('login');
    }
}
