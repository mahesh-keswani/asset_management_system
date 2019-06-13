<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function assets()
    {
        return $this->hasMany('App\Asset');
    }
    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }
    public function inventories()
    {
        return $this->hasMany('App\Inventory');
    }
    
}
