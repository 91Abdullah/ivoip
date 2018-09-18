<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    public function system_recording()
    {
    	return $this->belongsTo('App\SystemRecording');
    }

    public function announcementable()
    {
    	return $this->morphTo();
    }
}
