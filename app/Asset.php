<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public function users()
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
