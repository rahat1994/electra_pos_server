<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model

{

   //
   protected $fillable = [
       'productName',
       'productGroup',
       'warranty',
       'stockAlertCount',
       'code',
       'ProductDescription',
       'salePrice'
    ];

    public function productGroup(){

        return $this->belongsTo('App\Models\ProductGroup', 'productGroup');
    }

}
