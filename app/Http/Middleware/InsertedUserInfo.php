<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Adress;
use App\Models\Biography;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InsertedUserInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Adress::where('user_id', Auth::id())->exists() && Biography::where('user_id', Auth::id())->exists()){
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
