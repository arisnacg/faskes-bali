<?php

use Illuminate\Database\Seeder;
use App\FacilityType;
use App\Position;
use App\Condition;

class OtherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Kondisi
        $arrCon = ['Baik', 'Rusak', 'Hilang'];
        foreach($arrCon as $con){
            Condition::create([
                'name' => $con
            ]);
        }

    	//Jabatan
    	Position::truncate();
    	$arrPos = ['Staff', 'Kasi', 'Kabid'];
    	foreach($arrPos as $pos){
    		Position::create([
    			'name' => $pos
    		]);
    	}

    	//Faskes
    	FacilityType::truncate();
        FacilityType::create([
        	'name' => 'Gradil',
        	'about' => 'Keterangan Gradil'
        ]);

        FacilityType::create([
        	'name' => 'Rambu',
        	'about' => 'Keterangan Rambu'
        ]);

        FacilityType::create([
        	'name' => 'Patok',
        	'about' => 'Keterangan Patok'
        ]);

        FacilityType::create([
        	'name' => 'PJU',
        	'about' => 'Keterangan PJU'
        ]);
    }
}
