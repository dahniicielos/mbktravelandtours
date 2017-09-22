<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DropOffPoint extends Model
{
    protected $table = "drop_off_points";

    public function bus_travel_location()
    {
        return $this->hasMany('App\BusTravelLocation');
    }

    protected $fillable = ['origin', 'destination', 'drop_off_point', 'drop_off_point_name'];
}
