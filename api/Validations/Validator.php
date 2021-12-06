<?php

namespace Shelter\Validations;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
class Validator
{
    private static $errors = [];
    // A generic validation method. It returns true on success; an array of errors on false.
    public static function validate($request, array $rules)
    {
        foreach ($rules as $field => $rule) {
            // Retrieve a parameter from url or the request body; id can be sent in url or body.
            $param = $request->getAttribute($field) ?? $request->getParam($field);
            try {
                $rule->setName(ucfirst($field))->assert($param);
            } catch (NestedValidationException $ex) {
                self::$errors[$field] = $ex->getMessages();
            }
        }
        return empty(self::$errors);
    }
    // Validate attributes of an Employee model. Do not include fields having default values (id, role, etc.)
    public function validateEmployee($request)
    {
        $rules = [
            'employee_username' => v::noWhitespace()->notEmpty()->alnum(),
            'employee_password' => v::noWhitespace()->notEmpty(),
            'employee_first_name' => v::notEmpty(),
            'employee_last_name' => v::notEmpty(),
            'position_ID' => v::notEmpty(),
        ];
        return self::validate($request, $rules);
    }
    // Return the errors in an array
    public static function getErrors()
    {
        return self::$errors;
    }
}