<?php

namespace App\GraphQL\Queries;

class Employee
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $employeeList = \App\Models\Employee::take(20)->get();
        $data =[];
        foreach ($employeeList as $emp){
            $data[] = [
                'id'=>$emp->id,
                'name'=>$emp->name,
                'email'=>$emp->email,
                'phone'=>$emp->phone,
                'qualifications'=>''
            ];
        }
        return ($data);
    }
}
