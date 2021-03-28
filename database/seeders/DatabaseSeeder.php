<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =  Faker::create('en_AU');
        for ($i=0;$i<10;$i++) {
            \DB::table('locations')->insert([
                'name' => $faker->city
            ]);
        }

        $qualificationsNZ = [
            'Laundry (Finishing & Packing)' ,
            'Laundry (Washroom Procedures)' ,
            'Baking (Level 2)',
            'Baking (Level 3)',
            'Baking (Craft Baking) (Level 4)',
            'Baking (Plant Baking) (Level 4)',
            'Hospitality (Cafes) (Level 3)', 
            'Hospitality (Bars and Clubs) (Level 3)' ,
            'Hospitality (Level 3)',
            'Hospitality (Restaurant Service) (Level 4)' ,
        ];
        for ($i=0;$i<count($qualificationsNZ);$i++) {
            \DB::table('qualifications')->insert([
                'name' => $qualificationsNZ[$i]
            ]);
        }

        $roles = [
            'Manager',
            'Executive Chef',
            'Line Cook',
            'Server',
            'Bartender',
            'Cashier',
            'Busser',
            'Dishwasher',
        ];
        for ($i=0;$i<count($roles);$i++) {
            \DB::table('roles')->insert([
                'name' => $roles[$i]
            ]);
        }


        \App\Models\Employee::factory()->count(50)->create();
        \App\Models\Employee::all()->each(function ($emp){ 
            $qualifications = \App\Models\Qualification::inRandomOrder()->limit(3)->get();
            $emp->qualification()->attach(
                $qualifications->random(rand(0,$qualifications->count()))->pluck('id')->toArray()
            ); 
    });
    }
}
