<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Employee;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::truncate();
        $faker = Factory::create();
        for($i = 0; $i <= 10; $i++){
        	$employee = Employee::create([
        		'name' => $faker->name,
        		'nip' => mt_rand(1000, 2000),
        		'position_id' => mt_rand(1, 3)
        	]);
        }
    }
}
