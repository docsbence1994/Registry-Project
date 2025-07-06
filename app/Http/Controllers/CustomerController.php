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
            'end_time' => 'required|date|after:start_time',
            'repeat_type' => 'nullable|in:none,weekly,even_weeks,odd_weeks',
            'weekday' => 'nullable|integer|between:0,6',
            'time_of_day' => 'nullable|date_format:H:i:s',
        ]);

        if (empty($validated['repeat_type'])) {
            $validated['repeat_type'] = 'none';
        }

        $overlapping = Customer::where(function ($query) use ($validated) {
            $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
            ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
            ->orWhere(function ($q) use ($validated) {
              $q->where('start_time', '<=', $validated['start_time'])
                ->where('end_time', '>=', $validated['end_time']);
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
        $events = [];
        $customers = Customer::all();

        $now = new \DateTime();
        $limit = (clone $now)->modify('+3 months');

        foreach ($customers as $customer) {

            $start = new \DateTime($customer->start_time);
            $end = new \DateTime($customer->end_time);

            if ($customer->repeat_type === 'none') {
                $events[] = [
                    'title' => $customer->name,
                    'start' => $start->format('Y-m-d H:i:s'),
                    'end'   => $end->format('Y-m-d H:i:s'),
                ];
                continue;
            }

            $current = clone $start;
            $duration = $end->getTimestamp() - $start->getTimestamp();

            while ($current < $limit) {

                $weekNumber = (int)$current->format('W');
                $phpWeekday = (int)$current->format('N');

                $adjustedWeekday = $phpWeekday === 7 ? 0 : $phpWeekday;

                if ($adjustedWeekday === (int)$customer->weekday) {

                    $addEvent = false;

                    if ($customer->repeat_type === 'weekly') {
                        $addEvent = true;
                    } elseif ($customer->repeat_type === 'even_weeks' && $weekNumber % 2 === 0) {
                        $addEvent = true;
                    } elseif ($customer->repeat_type === 'odd_weeks' && $weekNumber % 2 !== 0) {
                        $addEvent = true;
                    }

                    if ($addEvent) {

                        $timeParts = explode(':', $customer->time_of_day);

                        if (count($timeParts) === 3) {
                            $eventStart = (clone $current)->setTime($timeParts[0], $timeParts[1], $timeParts[2]);
                            $eventEnd = (clone $eventStart)->modify("+{$duration} seconds");

                            $events[] = [
                                'title' => $customer->name,
                                'start' => $eventStart->format('Y-m-d H:i:s'),
                                'end'   => $eventEnd->format('Y-m-d H:i:s'),
                            ];
                        }
                    }
                }

                $current->modify('+1 day');
            }
        }

        return response()->json($events);
    }
}
