<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\DashboardController;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    public function store(Request $request, DashboardController $dashboardController)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'price' => 'required|numeric',
            'yearly_maintenance' => 'required|numeric',
            'payment_date' => 'required|date',
            'status' => 'required|string|max:50',
        ]);

        $validatedData['payment_date'] = Carbon::parse($validatedData['payment_date'])->format('Y-m-d H:i:s');

        $client = Client::create($validatedData);

        $dashboardData = $dashboardController->getDashboardData()->getData();

        return response()->json([
            'client' => $client,
            'dashboard_data' => $dashboardData
        ], 201);
    }


    public function update(Request $request, $id, DashboardController $dashboardController)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'price' => 'required|numeric',
            'yearly_maintenance' => 'nullable|numeric',
            'payment_date' => 'required|date',
            'status' => 'required|string',
        ]);

        $client = Client::findOrFail($id);
        $client->update($validatedData);

        $dashboardData = $dashboardController->getDashboardData()->getData();

        return response()->json([
            'client' => $client,
            'dashboard_data' => $dashboardData,
        ], 200);
    }

    public function destroy($id, DashboardController $dashboardController)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        $dashboardData = $dashboardController->getDashboardData()->getData();

        return response()->json($dashboardData);
    }
}