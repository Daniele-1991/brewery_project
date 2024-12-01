<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
 use Illuminate\Foundation\Application;
 
   use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
    use Illuminate\Session\Middleware\StartSession;
     use Illuminate\View\Middleware\ShareErrorsFromSession;
      
       use Illuminate\Routing\Middleware\SubstituteBindings;
        use Illuminate\Foundation\Configuration\Exceptions;
         use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
->withRouting( web: __DIR__.'/../routes/web.php', commands: __DIR__.'/../routes/console.php', health: '/up', )
  ->withMiddleware(function (Middleware $middleware) { 
    $middleware->group('web', [ EncryptCookies::class, AddQueuedCookiesToResponse::class, StartSession::class, ShareErrorsFromSession::class, VerifyCsrfToken::class, SubstituteBindings::class, ]);
            
    $middleware->group('api', [ SubstituteBindings::class, Authenticate::class, ]); }) ->withExceptions(function (Exceptions $exceptions) { //
         })->create();

