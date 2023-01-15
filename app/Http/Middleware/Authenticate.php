<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use App\Models\SettingGeneral;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $setting = SettingGeneral::first();
        if($setting->guest_checkout == 1 && (Str::startsWith(Route::currentRouteName(), 'checkout') || (Route::currentRouteName() == 'orders.show'))){
            
        }else{
            $this->authenticate($request, $guards);
        }
        return $next($request);
    }    
}
