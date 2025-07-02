<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function index()
    {
        return view('naptar');
    }

    public function events()
    {
        // Ide jön az adatbázisból a foglalások és ügyfélfogadási idők lekérése
        // Teszt adat:
        return response()->json([
            [
                'title' => 'Minta foglalás',
                'start' => '2025-07-02T10:00:00',
                'end' => '2025-07-02T11:00:00'
            ]
        ]);
    }

    public function store(Request $request)
    {
        // Ide jön az ellenőrzés és adatmentés
        return response()->json(['success' => true]);
    }
}
