<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function groups()
    {
        return $this->belongsTo('App\Group');
    }
    public function services()
    {
        return $this->belongsTo('App\Service');
    }
}
