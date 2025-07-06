<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::create([
            'name' => '1. Ügyfél',
            'start_time' => '2025-09-08 08:00:00',
            'end_time' => '2025-09-08 10:00:00',
            'repeat_type' => 'none',
            'weekday' => Carbon::parse('2025-09-08')->dayOfWeek,
            'time_of_day' => '08:00:00',
        ]);

        Customer::create([
            'name' => '2. Ügyfél',
            'start_time' => '2025-01-06 10:00:00',
            'end_time' => '2025-01-06 12:00:00',
            'repeat_type' => 'even_weeks',
            'weekday' => 1,
            'time_of_day' => '10:00:00',
        ]);

        Customer::create([
            'name' => '3. Ügyfél',
            'start_time' => '2025-01-01 12:00:00',
            'end_time' => '2025-01-01 16:00:00',
            'repeat_type' => 'odd_weeks',
            'weekday' => 3,
            'time_of_day' => '12:00:00',
        ]);

        Customer::create([
            'name' => '4. Ügyfél',
            'start_time' => '2025-01-03 10:00:00',
            'end_time' => '2025-01-03 16:00:00',
            'repeat_type' => 'weekly',
            'weekday' => 5,
            'time_of_day' => '10:00:00',
        ]);

        Customer::create([
            'name' => '5. Ügyfél',
            'start_time' => '2025-06-05 16:00:00',
            'end_time' => '2025-06-05 20:00:00',
            'repeat_type' => 'weekly',
            'weekday' => 4,
            'time_of_day' => '16:00:00',
        ]);
    }
}
