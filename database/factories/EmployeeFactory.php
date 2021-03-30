<?php

namespace Database\Factories;

use \App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {      
        $randRole = \App\Models\Role::inRandomOrder()->limit(1)->first();
        $randLocation = \App\Models\Location::inRandomOrder()->limit(1)->first();

   
    	return [
    	    'name' => $this->faker->name,
            'profile_picture' =>  '/media/default_avatar.jpg',
            'role_id' => $randRole->id ,
            'location_id'=>$randLocation->id ,
            
    	];
    }
}
