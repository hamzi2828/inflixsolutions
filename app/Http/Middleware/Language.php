<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App;
use Session;

class Language
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
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            $locale = 'en';
        }

        App::setLocale($locale);
        $request->session()->put('locale', $locale);

        return $next($request);
    }
}
