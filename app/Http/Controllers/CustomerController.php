<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CustomerController extends Controller {

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
        ]);

        Customer::create($validated);

        return response()->json(['success' => true]);
    }

    public function events() {
        $events = Customer::all()->map(function ($customer) {
            return [
                'title' => $customer->name,
                'start' => $customer->start_time,
                'end'   => $customer->end_time
            ];
        });

        return response()->json($events);
    }
}
