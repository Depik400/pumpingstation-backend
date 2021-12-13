<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periods extends Model
{
    use HasFactory;

    protected $table = 'periods';

    public $timestamps = false;

    protected $fillable = ['begin_date','end_date'];

    public static function createPeriod($date) {
        if(!$date) {
            $timestamp = date('Y-m-d H:i:s', time());
            $begin = new \DateTime($timestamp);
            $end = new \DateTime($timestamp);
        }else{
            $begin = date_create_from_format('Y-m-d',$date);
            $end = date_create_from_format('Y-m-d',$date);
        }
        $begin->modify('first day of this month');
        $begin->setTime(0,0,0);
        $end->modify('last day of this month');
        $end->setTime(23,59,59);

        $period = Periods::create([
            'begin_date'=>$begin-> format('Y-m-d H:i:s'),
            'end_date'=>$end-> format('Y-m-d H:i:s')
        ]);
        return $period;
    }

    public static function  getByTime(\DateTime $date) {
        return Periods::where('begin_date',$date->format('Y-m-d H:i:s'))->get();
    }

    public static function getFirstDayOfThisMonth() {
        $timestamp = date('Y-m-d H:i:s',time());
        $begin = new \DateTime($timestamp);
        $begin->modify('first day of this month');
        $begin->setTime(0,0,0);
        return $begin;
    }
}
