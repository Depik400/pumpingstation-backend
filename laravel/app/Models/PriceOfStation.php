<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceOfStation extends Model
{
    use HasFactory;

    protected $fillable = ['pumping_id','price_pairs'];
}
