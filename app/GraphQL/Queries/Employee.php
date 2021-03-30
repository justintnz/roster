<?php

namespace App\GraphQL\Queries;

class Employee
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function getAvailable($_, array $args)
    {
        // Lighthouse already filter this
        if (
            // !isset($args['role'])||
            !isset($args['location']) ||
            !isset($args['start_time']) ||
            !isset($args['shift_length'])
        ) {
            throw new \Exception('Missing role, location, start_time or shift_length ');
        }

        $shiftDate = date("Y-m-d", strtotime($args['start_time']));
        $onLeave   = \App\Models\Leave::select(\DB::raw('group_concat(employee_id) as employee_ids'))
            ->where('date', '=', $shiftDate)
            ->first();

        $onLeave = array_unique(explode(',', $onLeave->employee_ids));

        $startTime = strtotime($args['start_time']);
        $endTime   = date('Y-m-d H:i:s', $startTime + $args['shift_length'] * 60 * 60);
        $startTime = date('Y-m-d H:i:s', $startTime);
        $onShift   = \App\Models\Shift::select(\DB::raw('group_concat(employee_id) as employee_ids'))
            ->whereBetween('start_time', [$startTime, $endTime])
            ->orWhereBetween('end_time', [$startTime, $endTime])
            ->first();

        $onShift = array_unique(explode(',', $onShift->employee_ids));

        $employeeList = \App\Models\Employee::whereNotIn('id', $onLeave)
            ->whereNotIn('id', $onShift)
            ->where('location_id', $args['location'])
            ->take(20)->get();
        //$employeeList = $employeeList->where('role_id', $args['role']);

        // later referred by best_match
        $args['role'] = $args['role'] ?? 0;
        $reqDate =  $args['date'] ?? date('Y-m-d', time());


        $data = [];
        foreach ($employeeList as $oneEmp) {
            $data[] = [
                'id'                => $oneEmp->id,
                'name'              => $oneEmp->name,
                'profile_picture'   => $oneEmp->profile_picture,
                'prim_role'         => $oneEmp->role_id,
                'prim_location'     => $oneEmp->location_id,

                'locations'         => $oneEmp->locations,
                'qualifications'    => $oneEmp->qualifications,
                'roles'             => $oneEmp->getRoles(),
                'best_match'        => $oneEmp->role_id == $args['role'] ? 1 : 0,
                'week_hours'        => $oneEmp->weekHours($reqDate),

            ];
        }
        if ($args['role'] > 0)
            usort($data, function ($a, $b) {
                return $b['best_match'] - $a['best_match'];
            });
        return ($data);
    }


    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function getProfile($_, array $args)
    {
        // Lighthouse already filter this
        if (
            !isset($args['id'])
        ) {
            throw new \Exception('Missing id ');
        }


        $oneEmp = \App\Models\Employee::find($args['id']);
        if (!$oneEmp) {
            return [];
        }
        $reqDate =  $args['date'] ?? date('Y-m-d', time());
        return [
            'id'                => $oneEmp->id,
            'name'              => $oneEmp->name,
            'profile_picture'   => $oneEmp->profile_picture,
            'prim_role'         => $oneEmp->role_id,
            'prim_location'     => $oneEmp->location_id,

            'locations'         => $oneEmp->locations,
            'qualifications'    => $oneEmp->qualifications,
            'roles'             => $oneEmp->getRoles(),
            'leaves'            => $oneEmp->leaves,
            'shifts'            => $oneEmp->shifts,
            'week_hours'        => $oneEmp->weekHours($reqDate),

        ];
    }
}
