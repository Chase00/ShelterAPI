<?php

namespace Shelter\Models;

use \Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    // The table associated with this model
    protected $table = 'animal';
    protected $primaryKey = 'animal_ID';

    // Relationship: An animal can belong to one customer
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_ID');
    }

    // Get all animals, with pagination, sort and search by query features.
    public static function getAnimals($request)
    {

        // Get the total number of animals
        $count = self::count();

        // Get query string variables from url
        $params = $request->getQueryParams();

        // Do limit and offset exist?
        $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : 10; // items per page
        $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0; // offset of the first item

        // Get search terms
        $term = array_key_exists('q', $params) ? $params['q'] : null;

        if (!is_null($term)) {
            $animals = self::searchAnimals($term);
            return $animals;
        } else {
            // Pagination
            $links = self::getLinks($request, $limit, $offset);

            // Sorting
            $sort_key_array = self::getSortKeys($request);

            $query = Animal::with('customer');
            //$query = Message::all();
            $query = $query->skip($offset)->take($limit);  // limit the rows

            // Sort the output by one or more columns
            foreach ($sort_key_array as $column => $direction) {
                $query->orderBy($column, $direction);
            }

            $animals = $query->get();

            // Construct data for the response
            $results = [
                'totalCount' => $count,
                'limit' => $limit,
                'offset' => $offset,
                'links' => $links,
                'sort' => $sort_key_array,
                'data' => $animals
            ];
            return $results;
        }
    }

    // Get an animal by id
    public static function getAnimalById($id)
    {
        $animal = self::findOrFail($id);
        return $animal;
    }

    // Get a customer from an animal
    public static function getCustomerByAnimal($id)
    {
        $customer = self::findOrFail($id)->customer;
        return $customer;
    }

    // This function returns an array of links for pagination. The array includes links for the current, first, next, and last pages.
    public static function getLinks($request, $limit, $offset)
    {
        $count = self::count();

        // Get request uri and parts
        $uri = $request->getUri();
        $base_url = $uri->getBaseUrl();
        $path = $uri->getPath();

        // Construct links for pagination
        $links = array();
        $links[] = ['rel' => 'self', 'href' => $base_url . $path . "?limit=$limit&offset=$offset"];
        $links[] = ['rel' => 'first', 'href' => $base_url . $path . "?limit=$limit&offset=0"];
        if ($offset - $limit >= 0) {
            $links[] = ['rel' => 'prev', 'href' => $base_url . $path . "?limit=$limit&offset=" . ($offset - $limit)];
        }
        if ($offset + $limit < $count) {
            $links[] = ['rel' => 'next', 'href' => $base_url . $path . "?limit=$limit&offset=" . ($offset + $limit)];
        }
        $links[] = ['rel' => 'last', 'href' => $base_url . $path . "?limit=$limit&offset=" . $limit * (ceil($count / $limit) - 1)];

        return $links;
    }

    /*
     * Sort keys are optionally enclosed in [ ], separated with commas;
     * Sort directions can be optionally appended to each sort key, separated by :.
     * Sort directions can be 'asc' or 'desc' and defaults to 'asc'.
     * Examples: sort=[number:asc,title:desc], sort=[number, title:desc]
     * This function retrieves sorting keys from uri and returns an array.
    */
    public static function getSortKeys($request)
    {
        $sort_key_array = array();

        // Get querystring variables from url
        $params = $request->getQueryParams();

        if (array_key_exists('sort', $params)) {
            $sort = preg_replace('/^\[|\]$|\s+/', '', $params['sort']);  // remove white spaces, [, and ]
            $sort_keys = explode(',', $sort); //get all the key:direction pairs
            foreach ($sort_keys as $sort_key) {
                $direction = 'asc';
                $column = $sort_key;
                if (strpos($sort_key, ':')) {
                    list($column, $direction) = explode(':', $sort_key);
                }
                $sort_key_array[$column] = $direction;
            }
        }

        return $sort_key_array;
    }

    // Search animals
    public static function searchAnimals($terms)
    {
        if (is_numeric($terms)) {
            $query = self::where('animal_ID', "like", "%$terms%");
        } else {
            $query = self::where('animal_name', 'like', "%$terms%")
                ->orWhere('animal_breed', 'like', "%$terms%") ->orWhere('animal_type', 'like', "%$terms%");
        }
        $results = $query->get();
        return $results;
    }
}
