<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
	protected $primaryKey = 'name';

    protected $fillable = [
    	'name',
    	'musiconhold',
    	'announce',
    	'context',
    	'timeout',
    	'ringinuse',
    	'setinterfacevar',
    	'setqueuevar',
    	'setqueueentryvar',
    	'monitor_format',
    	'membermacro',
    	'membergosub',
    	'queue_youarenext',
    	'queue_thereare',
    	'queue_callswaiting',
    	'queue_quantity1',
    	'queue_quantity2',
    	'queue_holdtime',
    	'queue_minutes',
    	'queue_minute',
    	'queue_seconds',
    	'queue_thankyou',
    	'queue_callerannounce',
    	'queue_reporthold',
    	'announce_frequency',
    	'announce_to_first_user',
    	'min_announce_frequency',
    	'announce_round_seconds',
        'annound_position_only_up',
    	'announce_holdtime',
    	'announce_position',
    	'announce_position_limit',
    	'periodic_announce',
    	'periodic_announce_frequency',
    	'relative_periodic_announce',
    	'random_periodic_announce',
    	'retry',
    	'wrapuptime',
    	'penaltymemberslimit',
    	'autofill',
    	'monitor_type',
    	'autopause',
    	'autopausedelay',
    	'autopausebusy',
    	'autopauseunavail',
    	'maxlen',
    	'servicelevel',
    	'strategy',
    	'joinempty',
    	'leavewhenempty',
    	'reportholdtime',
    	'memberdelay',
    	'weight',
    	'timeoutrestart',
    	'defaultrule',
    	'timeoutpriority'
    ];

    public function users()
    {
    	return $this->belongsToMany('App\User', 'queue_user', 'queue_name', 'user_id');
    }
}
