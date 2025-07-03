<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CustomerController extends Controller {

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
        ]);

        $overlapping = Customer::where(function ($query) use ($validated) {
            $query->whereBetween('start', [$validated['start'], $validated['end']])
            ->orWhereBetween('end', [$validated['start'], $validated['end']])
            ->orWhere(function ($q) use ($validated) {
              $q->where('start', '<=', $validated['start'])
                ->where('end', '>=', $validated['end']);
            });
        })->exists();

        if ($overlapping) {
            return response()->json([
                'success' => false,
                'message' => 'Már van foglalás ebben az időszakban.'
            ], 409);
        }

        Customer::create($validated);

        return response()->json(['success' => true]);
    }

    public function events() {
        $events = Customer::all()->map(function ($customer) {
            return [
                'title' => $customer->name,
                'start' => $customer->start,
                'end'   => $customer->end,
            ];
        });

        return response()->json($events);
    }
}
