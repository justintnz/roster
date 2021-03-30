<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Support\Carbon;

class Employee extends Model
{
    use HasFactory;
    public function qualifications()
    {
        return $this->belongsToMany(Qualification::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function getRoles()
    {
        $roles = \DB::table('employee_role')
            ->join('roles', 'employee_role.role_id', '=', 'roles.id')
            ->select('employee_role.*', 'roles.name')
            ->where('employee_role.employee_id', $this->id)
            ->get()->toArray();

        //$roles = [['id' => 1, 'name' => 'MyRole', 'performance' => 5]];
        return $roles;
    }
    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
    public function isOnLeave(string $day = null): bool
    {
        $day = $day ?? date('Y-m-d', time());
        $leave = $this->hasOne(\App\Models\Leave::class)->where('date', $day)->first();
        return (null != $leave);
    }
    public function shifts()
    {
        return ($this->hasMany(Shift::class));
    }


    public function weekHours(string $date)
    {

        // the is a better approach if using MySQL timediff. 
        // This approach is not optimized, but will fit all DBMS 
        $date = strtotime($date);
        $start = (date('w', $date) == 0) ? $date : strtotime('last sunday', $date);
        $startTime = date('Y-m-d', $start) . ' 00:00:00';
        $endTime = date('Y-m-d', strtotime('next saturday', $start)) . ' 23:59:59';
        // \DB::connection()->enableQueryLog();

        $shifts   = \App\Models\Shift::select()
            ->where('employee_id', $this->id)
            ->whereBetween('start_time', [$startTime, $endTime])
            ->whereBetween('end_time', [$startTime, $endTime])
            ->get();
        // $queries = \DB::getQueryLog();

        $totalSecs = 0;
        foreach ($shifts as $shift) {
            $totalSecs += (strtotime($shift->end_time) - strtotime($shift->start_time));
        }
        return round($totalSecs / (3600), 2);
    }
}
