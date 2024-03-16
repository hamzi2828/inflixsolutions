<?php

namespace Plugin\TlcommerceCore\Models;

use Illuminate\Database\Eloquent\Model;
use Plugin\TlcommerceCore\Models\States;

class Country extends Model
{

    protected $table = "tl_countries";

    public function states()
    {
        return $this->hasMany(States::class, 'country_id', 'id');
    }
}
