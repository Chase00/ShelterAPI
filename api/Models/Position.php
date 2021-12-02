<?php

namespace Shelter\Models;

use \Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    // The table associated with this model
    protected $table = 'position';
    protected $primaryKey = 'position_ID';

    // Relationship: A position can have many employees
    public function position(){
        return $this->hasMany(Employee::class, 'employee_ID');
    }

    // Get all positions
    public static function getPositions(){
        $positions = self::all();
        return $positions;
    }

    // Get a position by id
    public static function getPositionByID($id){
        $positions = self::findOrFail($id);
        return $positions;
    }
}