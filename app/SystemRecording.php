<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemRecording extends Model
{
    public function announcement()
    {
    	return $this->hasOne('App\Announcement');
    }
}
