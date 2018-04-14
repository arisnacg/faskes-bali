<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        User::truncate();
    	User::create([
    		'email' => 'user1@mail.com',
    		'password' => bcrypt('password'),
    		'employee_id' => 1
    	]);
    }
}
