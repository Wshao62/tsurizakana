<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	$email = "higuchi@cplan-dcp.com";
	$pass = "gC8bjdfA";
	if (config('app.env') == 'local') {
	    $email = "admin@test.com";
	    $pass = "test123123";
	}
        DB::table('admins')->insert([
            [
                'name' => 'Master Admin',
                'email' => $email,
                'password' => Hash::make($pass),
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
