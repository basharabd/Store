<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class SetAppLocal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // $local = request('local' , Cookie::get('local', config('app.locale')));
        // Cookie::queue('local' , $local ,  60 * 24 *365);

          $locale = request('locale', Cookie::get('locale', config('app.locale')));

  
          App::setLocale($locale);

        Cookie::queue('locale', $locale, 60 * 24 * 365);

        return $next($request);

    }
}