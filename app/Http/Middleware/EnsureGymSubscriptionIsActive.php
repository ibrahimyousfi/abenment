<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureGymSubscriptionIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Super admin bypass
        if ($user && $user->isSuperAdmin()) {
            return $next($request);
        }
        
        // Check gym subscription for gym admins and staff
        if ($user && $user->gym) {
            $gym = $user->gym;
            
            // Check if subscription is expired
            if ($gym->isSubscriptionExpired()) {
                auth()->logout();
                return redirect()->route('subscription.expired')
                    ->with('error', 'انتهى اشتراك صالتك. يرجى تجديد الاشتراك للمتابعة.');
            }
            
            // Check for upcoming expiry (7 days warning)
            $daysUntilExpiry = $gym->getDaysUntilExpiry();
            if ($daysUntilExpiry !== null && $daysUntilExpiry <= 7 && $daysUntilExpiry > 0) {
                session(['subscription_warning' => true]);
                session(['days_until_expiry' => $daysUntilExpiry]);
            }
        }
        
        return $next($request);
    }
}
