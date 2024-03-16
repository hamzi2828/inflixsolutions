<?php

namespace Plugin\TlcommerceCore\Models;

use Illuminate\Database\Eloquent\Model;
use Plugin\TlcommerceCore\Models\States;

class Cities extends Model
{

    protected $table = "tl_com_cities";

    public function state()
    {
        return $this->belongsTo(States::class, 'state_id');
    }
}
