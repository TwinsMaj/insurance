<?php
declare(strict_types=1);

namespace Lib;

class Validator
{
    private $_rules;
    private $_method;
    private $_errors = [];

    public function __construct($rules, $method) {
        if (!$rules || !is_array($rules)) {
            throw new \Exception('Please provide an array of validation rules.');
        }

        $this->_rules = $rules;
        $this->_method = $method;
    }

    public function errors() {
        return $this->_errors;
    }

    public function has($field): bool {
        return array_key_exists($field, $this->_errors);
    }

    public function getMessage($field): string {
        return $this->_errors[$field];
    }

    public function hasErrors() {
        return count($this->_errors) > 0;
    }

    public function validate(): void
    {
        foreach($this->_rules as $field => $ruleSet) {
            $rules = explode('|', $ruleSet);

            foreach($rules as $rule) {
                list($ruleType, $param) = explode(':', $rule);

                switch($ruleType) {
                    case 'required':
                        if(empty($this->_method[$field]) && !array_key_exists($field, $this->_errors)) {
                            $this->_errors[$field] = "please provide a value";
                        }
                        break;
                    case 'numeric': 
                        if(!is_numeric($this->_method[$field]) && !array_key_exists($field, $this->_errors)) {
                            $this->_errors[$field] = "value must be a valid integer";
                        }
                        break;
                    case 'min':
                        if(($this->_method[$field] < $param) && !array_key_exists($field, $this->_errors)) {
                            $this->_errors[$field] = "minimum value allowed is: {$param}";
                        }
                        break;
                    case 'max':
                        if(($this->_method[$field] > $param) && !array_key_exists($field, $this->_errors)) {
                            $this->_errors[$field] = "maximum value allowed is: {$param}";
                        }
                }
            }
        }
    }

}