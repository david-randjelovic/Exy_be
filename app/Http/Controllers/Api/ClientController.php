<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'price' => 'required|numeric',
            'yearly_maintenance' => 'required|numeric',
            'payment_date' => 'required|date',
            'status' => 'required|string|max:50',
        ]);

        // Convert the payment_date to the required format
        $validatedData['payment_date'] = Carbon::parse($validatedData['payment_date'])->format('Y-m-d H:i:s');

        $client = Client::create($validatedData);

        return response()->json($client, 201);
    }

    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }
}