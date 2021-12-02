<?php

namespace Shelter\Models;

use \Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // The table associated with this model
    protected $table = 'customer';
    protected $primaryKey = 'customer_ID';

    // Relationship: An animal can belong to one customer
    public function animal(){
        return $this->belongsTo(Animal::class, 'animal_ID');
    }

    // Get all customers
    public static function getCustomers(){
        $customers = self::all();
        return $customers;
    }

    // Get a customer by id
    public static function getCustomerById($id){
        $customers = self::findOrFail($id);
        return $customers;
    }
}