<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusTravelLocation extends Model
{
    protected $guarded = ['id'];

    public function bus_inquiry()
    {
        return $this->belongsTo('App\BusInquiry');
    }

    public function drop_off_point()
    {
    	return $this->belongsToMany('App\DropOffPoint');
    }
}
