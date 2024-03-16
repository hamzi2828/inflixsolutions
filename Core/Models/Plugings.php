<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;

class Plugings extends Model
{
    protected $table = "tl_plugins";

    protected $fillable = array('name');
}
