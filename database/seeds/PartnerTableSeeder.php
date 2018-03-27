<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Partner;

class PartnerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partner::truncate();
        $faker = Factory::create();
        for($i = 0; $i <= 10; $i++){
        	$employee = Partner::create([
        		'name' => $faker->company,
        		'director' => $faker->name,
        		'email' => $faker->safeEmail,
        		'phone'=> $faker->tollFreePhoneNumber,
        		'address' => $faker->address,
        		'type' => mt_rand(1, 2)
        	]);
        }
    }
}
