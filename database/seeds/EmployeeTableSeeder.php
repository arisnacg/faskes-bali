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
    	Employee::create([
            'id' => 1,
    		'name' => 'Pegawai 1',
    		'nip' => '100000001',
    		'position_id' => 1
    	]);
    }
}
