<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemRecording extends Model
{
	protected $fillable = ['name', 'path'];

    public function announcement()
    {
    	return $this->hasOne('App\Announcement');
    }
}
