<?php

namespace App\Http\Controllers;

use App\Models\Periods;
use App\Models\Pump_meter_records;
use Illuminate\Http\Request;

class PumpMeterRecordsController extends Controller
{
   public function addNewPumpMeterRecord() {
       $begin = Periods::getFirstDayOfThisMonth();
       $periods = Periods::getByTime($begin);
       $requestedAmountArray = json_decode(\request()->get('residentsAmount'));
       $date = \request()->get('date');
        Pump_meter_records::createNewPumpRecord($requestedAmountArray,$periods,$date);
       return response()->json(['status'=> 201]);
   }
}
