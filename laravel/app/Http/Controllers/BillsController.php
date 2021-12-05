<?php

namespace App\Http\Controllers;

use App\Models\Bills;
use App\Models\Periods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillsController extends Controller
{
    //

    public function index(){
        $date = date_create_from_format('Y-m-d',\request()->get('date'));
        $date->setTime(0,0,0);
        $date->modify('first day of this month');
        return Bills::ResidentWithBill($date);
    }

    public function getUserWithoutBill()
    {
        $date = Periods::getFirstDayOfThisMonth();
        $date_from_url = \request()->query('date');
        if ($date_from_url != null) $date = date_create_from_format('Y-m-d', $date_from_url);
        $begin = $date->modify('first day of this month')->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        $end = $date->modify('last day of this month')->setTime(23, 59, 59)->format('Y-m-d H:i:s');
        $result = DB::select('select * from residents where residents.id not in
    (select bills.resident_id from bills
left join periods on bills.period_id = periods.id
where (begin_date >= \'' . $begin . '\' and end_date <=\'' . $end . '\' )
)
and pumping_id = ' . auth('api')->user()->id);
        return $result;


    }
}
