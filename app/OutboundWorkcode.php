<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutboundWorkcode extends Model
{
    protected $fillable = ['workcode', 'uniqueid', 'agent'];
}
