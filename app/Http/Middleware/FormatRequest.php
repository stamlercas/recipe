<?php

namespace Recipr\Http\Middleware;

use Closure;

class FormatRequest
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
        /*
        $keys = $request->keys();
        foreach ($keys as $key) {
            $temp[str_replace("_", " ", $key)] = $request[$key];
        }
        return $next($temp);
        */
        /*
        $temp = $request->all()->mapWithKeys(function($item, $key) {
            return [str_replace("_", " ", $key) => $item];
        });

        $request = $temp;
        return $next($request);
        */
    }
}
