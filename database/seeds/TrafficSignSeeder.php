<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\TrafficSign;
use App\TrafficSignType;

class TrafficSignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	TrafficSign::truncate();
    	TrafficSignType::truncate();

    	$faker = Factory::create();

        for($i = 1; $i <= 5; $i++){
        	TrafficSignType::create([
        		'name' => $faker->sentence(2)
        	]);
        }

        for($i = 1; $i <= 20; $i++){
        	TrafficSign::create([
        		'name' => $faker->sentence(2),
                'image' => 'test.jpg',
        		'traffic_sign_type_id' => ($i % 5) +1
        	]);
        }
    }
}
