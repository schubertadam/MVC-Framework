<?php

namespace App\Core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    // usage: [RULE_MIN, 'min' => number]
    public const RULE_MIN = 'min';
    // usage: [RULE_MAX, 'max' => number]
    public const RULE_MAX = 'max';
    // usage: [RULE_MATCH, 'match' => 'theInputName']
    public const RULE_MATCH = 'match'; // for passwords, etc.
    // usage: [RULE_UNIQUE, 'table' => 'tableName']
    public const RULE_UNIQUE = 'unique';
    // Contain errors by input name
    public array $errors = [];

    /** Return field rules by array
     *
     * e.g.: ['input' => [RULE_MIN, 'min' => 5 ]]
     * @return array
     */
    abstract public function rules(): array;

    /** Return user friendly label for input
     * @return array
     */
    abstract public function label(): array;

    /** Create variables from $_POST and $_GET
     * if that property exists in XYModel
     * e.g.: $_POST['username'] --> $username
     * @param array $data
     */
    public function loadData(array $data): void {
        foreach($data as $key => $value) {
            if(property_exists($this, $key)) {
                $this->{$key} = $value; // from key $_POST['username'] --> $username
            }
        }
    }

    public function validate(): bool {
        // get rules from specific model
        $data = $this->rules();

        // 'username' => [RULE_REQUIRED, etc.]
        foreach($data as $attribute => $rules) {
            // $value = $attribute NOT WORKING
            $value = $this->{$attribute}; // $value = value of the input

            foreach($rules as $rule) {
                $ruleName = $rule;

                if(!is_string($ruleName)) {
                    $ruleName = $rule[0]; // e.g.: [RULE_MATCH, 'match' => 'input'] <-- 0 is the rule
                }

                if($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorRule($attribute, self::RULE_REQUIRED);
                }

                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorRule($attribute, self::RULE_EMAIL);
                }

                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorRule($attribute, self::RULE_MIN, $rule);
                }

                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorRule($attribute, self::RULE_MAX, $rule);
                }

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    // [RULE_MATCH, 'match' => 'input_name']
                    $this->addErrorRule($attribute, self::RULE_MATCH);
                }

                if($ruleName === self::RULE_UNIQUE) {
                    $db = Application::$app->db;
                    $tableName = $rule['table'];

                    $db->query("SELECT * FROM $tableName WHERE $attribute = :attribute;");
                    $db->bindValue(':attribute', $this->{$attribute});

                    if($db->rowCount() > 0) {
                        $fieldName = $this->label()[$attribute]?? ucfirst($attribute);
                        $this->addErrorRule($attribute, self::RULE_UNIQUE, ['field' => $fieldName]);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    /** Add default rule error message for errors array
     * @param string $attribute
     * @param string $rule
     * @param array $params
     */
    private function addErrorRule(string $attribute, string $rule, array $params = []): void {
        $message = $this->errorMessage()[$rule] ?? 'There is an unknown error!';

        // in case of match, min, max and unique
        if(!empty($params)) {
            foreach($params as $key => $value) {
                $message = str_replace(":$key", $value, $message);
            }
        }

        $this->errors[$attribute][] = $message; // this can hold multiple errors for one attribute
    }

    /** Create custom error message for input
     * @param string $attribute
     * @param string $message
     */
    public function addErrorMessage(string $attribute, string $message): void {
        $this->errors[$attribute][] = $message;
    }

    public function hasError(string $attribute): bool {
        return isset($this->errors[$attribute]);
    }

    public function getFirstError(string $attribute): string {
        return $this->errors[$attribute][0] ?? '';
    }

    private function errorMessage(): array {
        return [
            self::RULE_REQUIRED => 'This field is required!',
            self::RULE_EMAIL => 'This field must contain a valid email address',
            self::RULE_MIN => 'This field must be at least :min characters',
            self::RULE_MAX => 'This field must be at most :max characters',
            self::RULE_MATCH => 'This field must be the same as: :match',
            self::RULE_UNIQUE => ':field already exists in the database!'
        ];
    }
}