<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->render(function (QueryException $e, Request $request) {
            if ($request->expectsJson()) {
                return null;
            }

            Log::error('Database error', [
                'message' => $e->getMessage(),
                'url' => $request->fullUrl(),
            ]);

            if ($request->isMethod('get')) {
                return response()->view('errors.500', [
                    'title' => 'Database problem',
                    'message' => 'The database could not complete that request. Please try again in a moment.',
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'The database could not complete that request. Please try again.');
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return null;
            }

            return response()->view('errors.404', [], 404);
        });

        $exceptions->render(function (HttpExceptionInterface $e, Request $request) {
            if ($request->expectsJson()) {
                return null;
            }

            $status = $e->getStatusCode();

            if ($status === 422 && ! $request->isMethod('get')) {
                return back()
                    ->withInput()
                    ->with('error', $e->getMessage() ?: 'Please check the form and try again.');
            }

            if ($status === 403) {
                return response()->view('errors.403', [], 403);
            }

            if ($status === 419) {
                return redirect()
                    ->route('login')
                    ->with('error', 'Your session expired. Please sign in again.');
            }

            if ($status >= 500) {
                return response()->view('errors.500', [], $status);
            }

            return null;
        });
    })->create();
