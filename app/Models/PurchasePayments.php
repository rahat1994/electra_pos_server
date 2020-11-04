<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model

{

   //

   protected $table = 'product_purchases';

   protected $fillable = [
       'purchase_id',
       'product_id',
       'quantity',
       'total_cost',
       'net_unit_cost'
    ];

}
