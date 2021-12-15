<?php

namespace Shelter\Models;

use \Illuminate\Database\Eloquent\Model;
use Shelter\Models\Position;
use Firebase\JWT\JWT;

class Employee extends Model
{
    public $timestamps = false;
    // The table associated with this model
    protected $table = 'employee';
    protected $primaryKey = 'employee_ID';

    // JWT variables
    const JWT_KEY = 'my token'; // Any token we like
    const JWT_EXPIRE = 600; // Expiration period in seconds (10 minutes)

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

    // Create a new employee
    public static function createEmployee($request)
    {
        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        // Create a new employee instance
        $employee = new Employee();

        // Set the employee's attributes
        foreach ($params as $field => $value) {

            // Need to hash password
            if ($field == 'employee_password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }

            $employee->$field = $value;
        }

        // Insert the employee into the database
        $employee->save();
        return $employee;
    }

    // Update an employee
    public static function updateEmployee($request)
    {
        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        //Retrieve the employee's id from url and then the user from the database
        $id = $request->getAttribute('id');
        $employee = self::findOrFail($id);

        // Update attributes of the professor
        $employee->employee_username = $params['employee_username'];
        $employee->employee_password = password_hash($params['employee_password'], PASSWORD_DEFAULT);
        $employee->employee_first_name = $params['employee_first_name'];
        $employee->employee_last_name = $params['employee_last_name'];
        $employee->employee_date_joined = $params['employee_date_joined'];
        $employee->position_ID = $params['position_ID'];

        // Update the employee
        $employee->save();
        return $employee;
    }

    // Delete a user
    public static function deleteEmployee($id)
    {
        $employee = self::findOrFail($id);
        return ($employee->delete());
    }

    // Authenticate an employee by username and password. Return the employee.
    public static function authenticateEmployee($employee_username, $employee_password)
    {
        $employee = self::where('employee_username', $employee_username)->first();
        if (!$employee) {
            return false;
        }
        return password_verify($employee_password, $employee->password) ? $employee : false;
    }

    /*
    * Generate a JWT token.
    * The signature secret rule: the secret must be at least 12 characters in length;
    * contain numbers; upper and lowercase letters; and one of the following special characters *&!@%^#$.
    * For more details, please visit https://github.com/RobDWaller/ReallySimpleJWT
    */

    public static function generateJWT($id)
    {
        // Data for payload
        $employee = $employee = self::findOrFail($id);
        if (!$employee) {
            return false;
        }
        $key = self::JWT_KEY;
        $expiration = time() + self::JWT_EXPIRE;
        $issuer = 'mychatter-api.com';
        $token = [
            'iss' => $issuer,
            'exp' => $expiration,
            'isa' => time(),
            'data' => [
                'uid' => $id,
                'name' => $employee->employee_username
            ]
        ];

        // Generate and return a token
        return JWT::encode(
            $token,   // Data to be encoded in the JWT
            $key,    // The signing key
            'HS256'   // Algorithm used to sign the token; defaults to HS256
        );
    }

    // Verify a token
    public static function validateJWT($token)
    {
        $decoded = JWT::decode($token, self::JWT_KEY, array('HS256'));

        return $decoded;
    }
}