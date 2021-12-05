<?php

namespace App\Http\Controllers;

use App\Models\PriceOfStation;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\DB;


class PriceOfStationController extends Controller
{
    //

    public function index()
    {
        return PriceOfStation::all();
    }

    public function getCurrentPricePair()
    {
        $userId = auth('api')->user()->id;
        $pricePairs = DB::table('price_of_stations')->where('pumping_id', $userId)->get('price_pairs')->first();
        return response()->json($pricePairs);
    }

    public function updateCurrentPricePair(Request $request)
    {
       DB::table('price_of_stations')->where('pumping_id', auth('api')->user()->id)
            ->update(['price_pairs' => $request->get('price_pair')]);
        return response()->json(['status' => 201]);
    }
}
