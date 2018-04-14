<?php

use Illuminate\Database\Seeder;
use App\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
         $this->call(EmployeeTableSeeder::class);
        // $this->call(PartnerTableSeeder::class);
        $this->call(OtherTableSeeder::class);
        $this->call(TrafficSignSeeder::class);
        App::truncate();
        App::create([
            'name' => 'FASKES PROV',
            'logo' => 'logo.png'
        ]);
    }
}
