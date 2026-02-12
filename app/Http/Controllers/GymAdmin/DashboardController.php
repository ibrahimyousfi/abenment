<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Redirect Super Admin to their dedicated dashboard
        if ($user->isSuperAdmin()) {
            return redirect()->route('super_admin.dashboard');
        }

        $gym = $user->gym;

        if (!$gym) {
            abort(403, 'Unauthorized action.');
        }

        // Member Statistics (scoped to gym)
        $totalMembers = $gym->members()->count();
        $activeMembers = $gym->members()->active()->count();
        $expiredMembers = $gym->members()->expired()->count();
        $inactiveMembers = $gym->members()->inactive()->count();

        // Expiring Soon (within 7 days) (scoped to gym)
        $expiringSoon = $gym->subscriptions()
            ->whereBetween('end_date', [
                now()->toDateString(),
                now()->addDays(7)->toDateString()
            ])->distinct('member_id')->count('member_id');

        // Revenue Statistics (scoped to gym)
        $subscriptionRevenue = $gym->subscriptions()->sum('price_snapshot');
        $productRevenue = $gym->orders()->sum('total_amount');
        $totalRevenue = $subscriptionRevenue + $productRevenue;

        // Recent Activities (scoped to gym)
        $recentMembers = $gym->members()->with('subscriptions.plan')
            ->latest()
            ->take(5)
            ->get();

        // Upcoming Maintenance (within 14 days)
        $upcomingMaintenance = $gym->equipment()
            ->whereHas('maintenanceLogs', function($q) {
                $q->whereBetween('next_maintenance_date', [
                    now()->toDateString(),
                    now()->addDays(14)->toDateString()
                ]);
            })
            ->with(['maintenanceLogs' => function($q) {
                $q->whereBetween('next_maintenance_date', [
                    now()->toDateString(),
                    now()->addDays(14)->toDateString()
                ])->orderBy('next_maintenance_date');
            }])
            ->get();

        // Chart Data: Monthly Revenue & Members (Last 6 Months)
        $months = collect(range(5, 0))->map(function($i) {
            return now()->subMonths($i);
        });

        $chartLabels = $months->map(fn($date) => $date->translatedFormat('M Y'));

        $revenueData = $months->map(function($date) use ($gym) {
            $subRevenue = $gym->subscriptions()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('price_snapshot');

            $orderRevenue = $gym->orders()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_amount');

            return $subRevenue + $orderRevenue;
        });

        $membersData = $months->map(function($date) use ($gym) {
            return $gym->members()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        });

        return view('gym_admin.dashboard', compact(
            'totalMembers',
            'activeMembers',
            'expiredMembers',
            'inactiveMembers',
            'expiringSoon',
            'subscriptionRevenue',
            'productRevenue',
            'totalRevenue',
            'recentMembers',
            'upcomingMaintenance',
            'chartLabels',
            'revenueData',
            'membersData'
        ));
    }
}
