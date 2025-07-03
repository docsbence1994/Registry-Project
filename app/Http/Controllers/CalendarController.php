<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar');
    }

    public function store(Request $request)
    {
        return response()->json(['success' => true]);
    }
}