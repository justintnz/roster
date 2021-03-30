<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Employee::get()->each(function ($emp) {

            for ($i = 0; $i < 10; $i++) {
                $start_time = date('Y-m-d H:i:s', time() + rand(0, 30) * rand(1, 24) * rand(1, 4) * 900);
                $end_time =   date('Y-m-d H:i:s', strtotime($start_time)  + rand(1, 24) * 60 * 60);
                \App\Models\Shift::create([
                    'location_id' => $emp->location_id,
                    'role_id' => $emp->role_id,
                    'employee_id' => $emp->id,
                    'start_time' => $start_time,
                    'end_time' => $end_time
                ]);
            }
        });
    }
}
