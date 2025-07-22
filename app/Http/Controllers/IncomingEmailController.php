<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IncomingEmailController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Email received:', $request->all());

        return response()->json(['message' => 'Email received']);
    }
}
