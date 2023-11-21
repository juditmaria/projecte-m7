<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasMultirole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $roles = explode(',', $roles); // Convertimos la lista de roles en un array
        $user = $request->user();

        foreach ($roles as $role) {
            /* dd($user->role_id, $role); */ // Añadido para depurar
           
            dd((int)$role);
            if ($user->hasRole((int)$role)) {
                return $next($request);
            }
        }

        $url = $request->url();
        return redirect('dashboard')->with('error', "Access denied to {$url}");
    }
}
