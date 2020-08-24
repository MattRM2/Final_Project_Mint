<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Psr7\Response;

use function PHPSTORM_META\type;

/**
 * Check if loggen in user has access to mentee profile.
 */
class MenteeProfileAccess
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
        $loggedInUser = $request->user();
        if ($loggedInUser->type === 'mentee' && $loggedInUser->id !== (int) $request->id) {
            return response()->view("unauthorized");
        }

        if ($loggedInUser->type === 'mentor' && $loggedInUser->mentees()->find($request->id) === null) {
            return response()->view("unauthorized");
        }

        return $next($request);
    }
}
