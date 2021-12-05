<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bills extends Model
{
    use HasFactory;

    protected $fillable = ['resident_id', 'period_id', 'amount_rub'];

    protected $table = 'bills';

    public $timestamps = false;

    public static function CreateNewBill($resident_id, $period_id, $amount_volume,$date)
    {
        $month = date_create_from_format('Y-m-d',$date)->format('m');
        $cost = PriceOfStation::where('pumping_id', auth('api')->user()->id)->get();
        $price = json_decode($cost[0]);
        $price = json_decode($price->price_pairs);
        $current_price = 0;
        foreach ($price as $singleprice) {
            //echo $singleprice;
            if ($singleprice->month == $month - 1) {
                $current_price = $singleprice->price;
            }
        }
        $amount_rub = $current_price * $amount_volume;
        Bills::create([
            'resident_id' => $resident_id,
            'period_id' => $period_id,
            'amount_rub' => $amount_rub,
        ]);
    }

    public static function ResidentWithBill($date): array
    {
        return DB::select('select fio,amount_rub,begin_date,end_date,bills.id, amount_volume from bills left join periods on periods.id = bills.period_id
left join residents on bills.resident_id = residents.id left join pump_meter_records on periods.id = pump_meter_records.period_id where pumping_id = '
            . auth('api')->user()->id.' and begin_date = \''.$date->format('Y-m-d H:i:s').'\'');
    }

}
