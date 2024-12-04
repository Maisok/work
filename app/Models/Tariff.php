<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = [
        'id_user', 'price_day', 'price_day_one_advert', 'price_month', 'adverts', 'status'
    ];
}