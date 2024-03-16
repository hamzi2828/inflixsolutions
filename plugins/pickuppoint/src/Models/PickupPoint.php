<?php

namespace Plugin\PickupPoint\Models;

use Illuminate\Database\Eloquent\Model;
use Plugin\TlcommerceCore\Models\ShippingZone;

class PickupPoint extends Model
{
    protected $table = "tl_pick_up_points";

    public function zoneInfo()
    {
        return $this->belongsTo(ShippingZone::class, 'zone');
    }
}
