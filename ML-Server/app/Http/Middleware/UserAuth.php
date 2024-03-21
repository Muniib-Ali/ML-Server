<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authstatus = Auth::user();
        if(User::count()== 0){
            return redirect('/initialize');
        }elseif(empty($authstatus)){
            return redirect('/login');
        }
        if(!empty($authstatus)) {
            $is_admin = $authstatus->is_admin;
        if($is_admin == true){
            return redirect()->back();
        }
        }
        return $next($request);
    }
}
