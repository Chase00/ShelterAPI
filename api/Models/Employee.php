<?php

namespace Shelter\Models;

use \Illuminate\Database\Eloquent\Model;
use Shelter\Models\Position;

class Employee extends Model
{
    // The table associated with this model
    protected $table = 'employee';
    protected $primaryKey = 'employee_ID';

    // Relationship: An employee belongs to one position
    public function position(){
        return $this->belongsTo(Position::class, 'position_ID');
    }

    // Get all employees
    public static function getEmployees(){
        $employees = self::all();
        return $employees;
    }

    // Get an employee by id
    public static function getEmployeeById($id){
        $employees = self::findOrFail($id);
        return $employees;
    }
}