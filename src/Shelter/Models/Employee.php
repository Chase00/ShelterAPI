<?php

namespace Shelter\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';
    protected $primaryKey = 'employee_ID';

    //Inverse of the one-to-many relationship
    public function position(){
        return $this->belongsTo(Position::class, 'position_ID');
    }

}