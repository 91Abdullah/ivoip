<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

	    DB::table('roles')->insert(
	    	['name' => 'Agent'], ['name' => 'Reporter'], ['name' => 'Blended'], ['name' => 'Supervisor'], ['name' => 'Outbound']
	    );
    }
}
