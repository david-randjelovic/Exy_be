<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\DashboardController;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();
        return response()->json($expenses);
    }

    public function store(Request $request, DashboardController $dashboardController)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'payment_date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $expense = new Expense();
        $expense->type = $request->type;
        $expense->company = $request->company;
        $expense->cost = $request->cost;
        $expense->payment_date = $request->payment_date;
        $expense->status = $request->status;
        $expense->save();

        $dashboardData = $dashboardController->getDashboardData()->getData();

        $expense->dashboard_data = $dashboardData;

        return response()->json($expense, 201);
    }

    public function destroy($id, DashboardController $dashboardController)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        $dashboardData = $dashboardController->getDashboardData()->getData();

        return response()->json($dashboardData);
    }
}
