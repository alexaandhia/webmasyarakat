<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        //...$roles buat mengubah string yg dipisah dengan koma jadi item array, namanya spread operaator
        // $request->user()->role akan ambil data user yang login bagian role
        if(in_array($request->user()->role, $roles)){
            return $next($request);
        }else{
            return redirect()->back();
        }
    }
}
