<?php

use App\Http\Middleware\Admin\EmailIsVerified;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath;
use Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->group(base_path('routes/student.php'));

            Route::group([], base_path('routes/webhook.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            return route('login');
        });

        $middleware->redirectUsersTo(function (Request $request) {
            // If accessing admin area, check admin guard and redirect to admin dashboard
            if ($request->is('admin') || $request->is('admin/*')) {
                if (Auth::guard('admin')->check()) {
                    return route('admin.dashboard');
                }
            }

            // For student/regular area, check web guard and redirect to student dashboard
            if (Auth::guard('web')->check()) {
                return route('dashboard');
            }

            return route('landing-page');
        });

        $middleware->alias([
            'admin.verified' => EmailIsVerified::class,
            'localize' => LaravelLocalizationRoutes::class,
            'localizationRedirect' => LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect' => LocaleSessionRedirect::class,
            'localeCookieRedirect' => LocaleCookieRedirect::class,
            'localeViewPath' => LaravelLocalizationViewPath::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                if ($e instanceof HttpExceptionInterface) {
                    $status = $e->getStatusCode();

                    if (view()->exists("admin.error_pages.{$status}")) {
                        return response()->view("admin.error_pages.{$status}", ['exception' => $e], $status);
                    }
                } elseif (! config('app.debug')) {
                    if (view()->exists('admin.error_pages.500')) {
                        return response()->view('admin.error_pages.500', ['exception' => $e], 500);
                    }
                }
            }
        });
    })->create();
