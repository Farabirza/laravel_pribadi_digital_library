<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveMiddleware
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
        if(Auth::check()) {
            switch(Auth::user()->status) {
                case 'suspended':
                    return redirect('/profile')->with('error', "Your account is being suspended, ask admin to re-activate your account");
                break;
                case 'confirmation':
                    return redirect('/confirmation')->with('info', "Input the confirmation key or ask other teacher to confirm you");
                break;
            }
            if(Auth::user()->profile && Auth::user()->profile->role != 'student' && Auth::user()->confirmation == 0) {
                return redirect('/confirmation')->with('info', "Input the confirmation key or ask other teacher to confirm you");
            }
        }
        return $next($request);
    }
}
