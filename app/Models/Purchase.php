<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model

{
   protected $fillable = [
       'product_id',
       'supplier_id',
       'quantity',
       'total_cost',
       'net_unit_cost',
       'paid_amount',
       'status',
       'payment_status'
    ];

}
