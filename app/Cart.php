<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {

    /**
     * 
     * @return App\Product
     */
    public function product() {
        return $this->hasOne('App\Product','id','product_id');
    }
    

}
