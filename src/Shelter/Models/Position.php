<?php

namespace Shelter\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'position';
    protected $primaryKey = 'position_ID';

    //map the one-to-many relationship
    public function animals()
    {
        return $this->hasOne(Employee::class, 'position_ID');
    }
}