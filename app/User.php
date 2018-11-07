<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'extension', 'secret'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function queues()
    {
        return $this->belongsToMany('App\Queue', 'queue_user', 'user_id', 'queue_name');
    }

    public function scopeGetByExtension($query, $name)
    {
        return $query->where("extension", $name)->first();
    }

    public function isSuperAdmin()
    {
        if($this->roles->contains("name", "Reporter"))
            return true;
        else return false;
    }

    public function isAgent()
    {
        if($this->roles->contains("name", "Agent"))
            return true;
        else return false;
    }

    public function isBlended()
    {
        if($this->roles->contains("name", "Blended"))
            return true;
        else return false;
    }

    public function isOutbound()
    {
        if($this->roles->contains("name", "Outbound"))
            return true;
        else return false;
    }

    public function isSupervisor()
    {
        if($this->roles->contains("name", "Supervisor"))
            return true;
        else return false;
    }
}
