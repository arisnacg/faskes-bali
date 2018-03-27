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
        for($i = 1; $i <= 10; $i++){
        	$user = User::create([
        		'email' => $faker->safeEmail,
        		'password' => 'password',
        		'employee_id' => $i
        	]);
        }
    }
}
