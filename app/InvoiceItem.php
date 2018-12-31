<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'item_id',
        'quantity',
        'unit_price',
        'sub_total_price'
    ];

    protected $table = 'invoice_items';
}
