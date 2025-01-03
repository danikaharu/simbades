<?php

use App\Console\Commands\ResetMonthlyStatus;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\App\Http\Middleware\UpgradeToHttpsUnderNgrok::class);
        $middleware->web(append: [
            \RealRashid\SweetAlert\ToSweetAlert::class,
        ]);
    })
    ->withCommands([
        ResetMonthlyStatus::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
