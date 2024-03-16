<?php

namespace Plugin\TlcommerceCore\Models;

use Illuminate\Database\Eloquent\Model;
use Plugin\TlcommerceCore\Models\Country;

class States extends Model
{

    protected $table = "tl_com_state";

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function cities()
    {
        return $this->hasMany(Cities::class,'state_id');
    }
}
