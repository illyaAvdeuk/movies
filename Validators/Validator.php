<?php
namespace Validators;

/**
 * Class Validator
 * @package Validators
 */
class Validator
{
    protected function checkString($string, $fieldName)
    {
        if(!empty($string) && !is_string($string)){
            return sprintf('%s has to be string', $fieldName);
        }
    }

    protected function isRequired($fieldName)
    {
        return sprintf('%s is required field', $fieldName);
    }
}