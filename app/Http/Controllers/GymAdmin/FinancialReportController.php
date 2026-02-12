<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    private function getGym()
    {
        return auth()->user()->gym;
    }

    public function index(Request $request)
    {
        $gym = $this->getGym();
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // 1. Revenue (Payments)
        $revenue = $gym->payments()
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->sum('amount');

        // 2. Expenses
        $expenses = $gym->expenses()
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->sum('amount');

        // 3. Net Profit
        $netProfit = $revenue - $expenses;

        // 4. Revenue by Category (Invoice Type)
        $revenueByType = $gym->payments()
            ->join('invoices', 'payments.invoice_id', '=', 'invoices.id')
            ->whereBetween('payments.payment_date', [$startDate, $endDate])
            ->select('invoices.type', DB::raw('sum(payments.amount) as total'))
            ->groupBy('invoices.type')
            ->pluck('total', 'type');

        // 5. Expenses by Category
        $expensesByCategory = $gym->expenses()
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->select('category', DB::raw('sum(amount) as total'))
            ->groupBy('category')
            ->pluck('total', 'category');

        // 6. Monthly Trend (Last 6 Months) - For Chart
        $trendLabels = [];
        $trendRevenue = [];
        $trendExpenses = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $trendLabels[] = $date->format('M Y');
            
            $trendRevenue[] = $gym->payments()
                ->whereYear('payment_date', $date->year)
                ->whereMonth('payment_date', $date->month)
                ->sum('amount');
                
            $trendExpenses[] = $gym->expenses()
                ->whereYear('expense_date', $date->year)
                ->whereMonth('expense_date', $date->month)
                ->sum('amount');
        }

        return view('gym_admin.reports.financial', compact(
            'startDate', 'endDate',
            'revenue', 'expenses', 'netProfit',
            'revenueByType', 'expensesByCategory',
            'trendLabels', 'trendRevenue', 'trendExpenses'
        ));
    }
}
