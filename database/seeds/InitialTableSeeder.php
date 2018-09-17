<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Setting;

class InitialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
        	[
	        	'name' => 'Abdullah Basit',
	        	'email' => 'abdullah.basit@hotmail.com',
	        	'password' => Hash::make('abdullah'),
	        	'extension' => null,
	        	'secret' => null
	        ]
	    );

	    $data = [
	    	['name' => 'Agent'], ['name' => 'Reporter'], ['name' => 'Supervisor'], ['name' => 'Outbound'], ['name' => 'Blended']
	    ];

	    DB::table('roles')->insert(
	    	$data
	    );

	    DB::table('role_user')->insert(
	    	[
	    		'user_id' => 1,
	    		'role_id' => 2
	    	]
	    );

	    $request = ['127.0.0.1', 5038, 'manager_application', 'abdullah', 20, 100, 'app_wallboard', 'abdullah'];

	    $settings = ['host', 'port', 'username', 'secret', 'connect_timeout', 'read_timeout', 'wallboard_username', 'wallboard_secret'];

    	foreach ($settings as $key => $value) {
    		Setting::set($value, $request[$value]); 
    	}
    }
}
