<?php

namespace App\Http\Middleware;

use App\Model\Store;
use App\Model\User;
use Closure;

class NotSeller
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
        // If not login -> go to login page
        if (!auth()->check()) {
            // @todo: place right login page.
            return redirect(
                route('login')
            );
        }

        /** @var User $user */
        $user = auth()->user();

        // If user have store, go to seller home page.
        if ($user->store && $user->store->status !== Store::STATUS_DRAFT) {
            return redirect(
                route('seller.home')
            );
        }

        return $next($request);
    }
}
