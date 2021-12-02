<?php

namespace Shelter\Models;

class Food
{
    // The table associated with this model
    protected $table = 'animalfood';
    protected $primaryKey = 'animalFood_ID';

    // Get all food items
    public static function getFood(){
        $food = self::all();
        return $food;
    }

    // Get a food item by id
    public static function getFoodByID($id){
        $food = self::findOrFail($id);
        return $food;
    }
}