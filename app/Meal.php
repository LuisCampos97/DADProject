<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'state',
        'table_number',
        'start',
        'end',
        'responsible_waiter_id',
        'total_price_preview'
    ];
}
