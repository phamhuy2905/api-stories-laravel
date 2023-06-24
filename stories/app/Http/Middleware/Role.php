<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if($request->user()->role !== $role && $request->user()->role == 'user') {
            return response()->json([
                'message' => 'Forbidden!'
            ],403);
        }
        if($request->user()->role !== $role) {
            return redirect()->back();
        }
        return $next($request);
    }
}
