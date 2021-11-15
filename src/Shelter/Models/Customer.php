<?php

namespace Shelter\Models;

class Customer extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_ID';

    //map the one-to-many relationship
    public function animals()
    {
        return $this->hasOne(Animal::class, 'customer_ID');
    }
}