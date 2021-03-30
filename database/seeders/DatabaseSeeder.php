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
        for ($i = 0; $i < 10; $i++) {
            \App\Models\Location::create([
                'name' => $faker->city
            ]);
        }

        $qualificationsNZ = [
            'Laundry (Finishing & Packing)',
            'Laundry (Washroom Procedures)',
            'Baking (Level 2)',
            'Baking (Level 3)',
            'Baking (Craft Baking) (Level 4)',
            'Baking (Plant Baking) (Level 4)',
            'Hospitality (Cafes) (Level 3)',
            'Hospitality (Bars and Clubs) (Level 3)',
            'Hospitality (Level 3)',
            'Hospitality (Restaurant Service) (Level 4)',
        ];
        for ($i = 0; $i < count($qualificationsNZ); $i++) {
            \App\Models\Qualification::create([
                'name' => $qualificationsNZ[$i]
            ]);
        }

        $roles = [
            'Manager',
            'Executive Chef',
            'Line Cook',
            'Server',
            'Bartender',
            'Bartender2',
            'Cashier',
            'Cashier2',
            'Busser',
            'Dishwasher',
        ];

        for ($i = 0; $i < count($roles); $i++) {
            \App\Models\Role::create([
                'name' => $roles[$i]
            ]);
        }

        for ($i = 1; $i < 10; $i++) {
            \App\Models\Employee::create([
                'name' => 'Employee' . $i,
                'profile_picture' =>  '/media/default_avatar.jpg',
                'role_id' => $i,
                'location_id' => $i,
            ]);
        }

        // Create 10 empl with same role
        for ($i = 1; $i < 10; $i++) {
            \App\Models\Employee::create([
                'name' => 'Employee' . ($i + 10),
                'profile_picture' =>  '/media/default_avatar2.jpg',
                'role_id' => 5,
                'location_id' => $i,
            ]);
        }

        // Create 10 empl with same location

        for ($i = 1; $i < 10; $i++) {
            \App\Models\Employee::create([
                'name' => 'Employee' . ($i + 20),
                'profile_picture' =>  '/media/default_avatar3.jpg',
                'role_id' => $i,
                'location_id' => 5,
            ]);
        }

        \App\Models\Employee::factory()->count(50)->create();
        \App\Models\Employee::all()->each(function ($emp) {

            $locations = \App\Models\Location::inRandomOrder()->limit(3)->get();
            $emp->locations()->attach(
                $locations->random(rand(1, $locations->count()))->pluck('id')->toArray()
            );


            if (rand(0, 2) > 0) {
                $qualifications = \App\Models\Qualification::inRandomOrder()->limit(3)->get();
                $emp->qualifications()->attach(
                    $qualifications->random(rand(0, $qualifications->count()))->pluck('id')->toArray()
                );
            }

            $emp->roles()->attach(
                $emp->prim_role,
                ['performance' => rand(4, 10) / 2]
            );

            if (rand(0, 2) > 0) {
                $roles = \App\Models\Role::inRandomOrder()->limit(2)->get();
                $emp->roles()->attach(
                    $roles->random(rand(0, $roles->count()))->pluck('id')->toArray(),
                    ['performance' => rand(0, 10) / 2]
                );
            }

            for ($i = 0; $i < rand(0, 5); $i++) {
                $leaveDay = date('Y-m-d', time() + rand(0, 30) * 24 * 60 * 60);
                \App\Models\Leave::create(['date' => $leaveDay, 'employee_id' => $emp->id]);
            }
        });
    }
}
