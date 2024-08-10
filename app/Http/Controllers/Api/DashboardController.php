<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getDashboardData()
    {
        $totalClients = Client::count();

        $totalIncome = Client::sum('price');
        $totalExpenses = Expense::sum('cost');
        $totalProfit = $totalIncome - $totalExpenses;

        $currentYear = Carbon::now()->year;

        $yearlyIncome = Client::whereYear('payment_date', $currentYear)->sum('price');
        $yearlyExpenses = Expense::whereYear('payment_date', $currentYear)->sum('cost');
        $yearlyProfit = $yearlyIncome - $yearlyExpenses;

        // $yearlyIncome = floatval($yearlyIncome);
        // $yearlyExpenses = floatval($yearlyExpenses);

        $yearlyClients = Client::whereYear('created_at', $currentYear)->count();

        return response()->json([
            'total_clients' => $totalClients,
            'total_profit' => $totalProfit,
            'yearly_profit' => $yearlyProfit,
            'yearly_clients' => $yearlyClients
        ]);
    }
}