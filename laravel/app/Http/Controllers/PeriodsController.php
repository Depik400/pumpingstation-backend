<?php

namespace App\Http\Controllers;

use App\Models\Periods;
use Illuminate\Http\Request;

class PeriodsController extends Controller
{

    public function index(){
        return Periods::all();
    }

    public function addPeriod(): \Illuminate\Http\JsonResponse
    {
        Periods::createPeriod(null);
        return response()->json([status => 'status']);
    }
}
