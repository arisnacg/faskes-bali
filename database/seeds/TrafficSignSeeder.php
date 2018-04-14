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

    	TrafficSignType::create([
            'id' => 1,
    		'name' => 'Rambu larangan'
    	]);

        $rambuLarangan = array(
            '/images/rambu/1/1a.png',
            '/images/rambu/1/1b.png',
            '/images/rambu/1/1c.png',
            '/images/rambu/1/1d.png',
            '/images/rambu/1/1f.png',
            '/images/rambu/1/2a1.png',
            '/images/rambu/1/2a2.png',
            '/images/rambu/1/2b1.png',
            '/images/rambu/1/2b2.png',
            '/images/rambu/1/2b3.png',
            '/images/rambu/1/2b4.png',
            '/images/rambu/1/2b5.png',
            '/images/rambu/1/2b6.png',
            '/images/rambu/1/2b7.png',
            '/images/rambu/1/2b8.png',
            '/images/rambu/1/2b9.png',
            '/images/rambu/1/2b10.png',
            '/images/rambu/1/2b11.png',
            '/images/rambu/1/2b12.png',
            '/images/rambu/1/2b13.png',
            '/images/rambu/1/2c1.png',
            '/images/rambu/1/2c2.png',
            '/images/rambu/1/2c3.png',
            '/images/rambu/1/2c4.png',
            '/images/rambu/1/2c5.png',
            '/images/rambu/1/2c6.png',
            '/images/rambu/1/2c7.png',
            '/images/rambu/1/2c8.png',
            '/images/rambu/1/2c33.png',
            '/images/rambu/1/2d1.png',
            '/images/rambu/1/2d2.png',
            '/images/rambu/1/2d3.png',
            '/images/rambu/1/2d4.png'
        );

        for($i = 0; $i < count($rambuLarangan); $i++){
        	TrafficSign::create([
                'src' => $rambuLarangan[$i],
        		'traffic_sign_type_id' => 1
        	]);
        }
    }
}
