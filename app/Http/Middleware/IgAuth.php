<?php

namespace App\Http\Middleware;
use Closure;

class IgAuth
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
        $user = \Auth::user();
        if (empty($user->ig_attrs)) {
            return redirect('/home');
        }
        $request->merge([
            'is_ig_authed' => $user->is_ig_authed,
            'ig_attrs' => $user->ig_attrs,
            'albums' => $user->albums,
            'ig_username' => $user->getIg('username'),
        ]);
        \Log::info('middddlleeeee');

        return $next($request);
    }
}
