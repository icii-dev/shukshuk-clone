<?php

namespace App\Http\Middleware;

use App\Model\Store;
use Closure;

class CheckSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $user = auth()->user()->toArray();
//        if($user['role_id']==4){
//            return $next($request);
//        }
        if(auth()->user()->store && auth()->user()->store->status != Store::STATUS_DRAFT) {
            return $next($request);
        } else {
            return redirect(
                route('seller.register.step_1')
            );
        }

        return abort(403, 'You must login with a sales account');
    }
}
