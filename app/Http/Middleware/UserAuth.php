<?php

namespace app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuth{
    public function handle(Request $request, Closure $next, $role){
        if(auth()->user()->role == $role){
            return $next($request);
        }
        abort(401);
    }
}
?>