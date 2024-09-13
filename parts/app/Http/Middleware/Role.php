<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    protected $hierarchy =[
        'admin' => 2,
        'employee' => 1,
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = auth()->user();
        if($this->hierarchy[$user->role] < $this->hierarchy[$role]){
            abort(404);
        }

        return $next($request);
    }
}
