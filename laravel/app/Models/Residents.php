<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Residents extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'residents';

    protected $fillable = [
        'fio',
        'area',
        'pumping_id'
    ];
}
