<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {

        $middleware->append(HandleCors::class);

        $middleware->alias([
            'admin.role' => \App\Http\Middleware\AdminRoleMiddleware::class,
        ]);

        // Tránh chuyển hướng đến trang login khi chưa đăng nhập cho API
        $middleware->redirectTo(function (Request $request) {
            if ($request->is('api/*')) {
                return null;
            }
            // Nếu có trang login cho web thì trả về route('login'), 
            // hiện tại không có nên trả về null để báo lỗi 401 thay vì lỗi RouteNotFound
            return null; 
        });

    })

    ->withExceptions(function (Exceptions $exceptions): void {

        // Bắt buộc trả về JSON cho các route API
        $exceptions->shouldRenderJsonWhen(function (Request $request, \Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }

            return $request->expectsJson();
        });

        // Lỗi xác thực (Chưa đăng nhập)
        $exceptions->render(function (AuthenticationException $e, Request $request) {

            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);

        });

        // Lỗi validate dữ liệu
        $exceptions->render(function (ValidationException $e, Request $request) {

            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);

        });

        // Lỗi không tìm thấy route (404) trong API
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {

            if ($request->is('api/*')) {

                return response()->json([
                    'status' => false,
                    'message' => 'Đường dẫn API không tồn tại'
                ], 404);

            }

        });

    })

    ->create();