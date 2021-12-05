<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pump_meter_records extends Model
{
    use HasFactory;

    protected $table = 'pump_meter_records';

    public $timestamps = false;

    protected $fillable = ['amount_volume','period_id'];

    public static function createNewPumpRecord($requestedAmountArray,$periods,$date) {
        $skipIf = true;
        for($j = 0; $j < count($requestedAmountArray);) {
            $item = $requestedAmountArray[$j];
            if(count($periods) > 0 && $skipIf) {
                for($i = 0; $i < count($periods);$i++){
                    $item = $requestedAmountArray[$j];
                    $period = $periods[$i];
                    $pump_meter = Pump_meter_records::where('period_id',$period->id)->get();
                    if(count($pump_meter) <= 0){
                        Pump_meter_records::create([
                            'period_id' => $period->id,
                            'amount_volume' => $item->amount
                        ]);
                        Bills::CreateNewBill($item->residentIndex,$period->id,$item->amount,$date);
                        $j++;
                        if($j == count($requestedAmountArray)){
                            return;
                        }
                    }
                }
                $skipIf = false;
            }else{
                $new_period = Periods::createPeriod($date);
                Pump_meter_records::create([
                    'period_id' => $new_period->id,
                    'amount_volume' => $item->amount
                ]);
                Bills::CreateNewBill($item->residentIndex,$new_period->id,$item->amount,$date);
                $j++;
            }
        }
    }

}
