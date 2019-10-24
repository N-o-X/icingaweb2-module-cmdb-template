<?php

namespace Icinga\Module\Cmdb\Form\Validator;

use ipl\Stdlib\Contract\ValidatorInterface;

class LengthValidator implements ValidatorInterface
{
    protected $length;

    public function __construct($length)
    {
        $this->length = $length;
    }

    /**
     * Get whether the given value is valid
     *
     * @param mixed $value
     *
     * @return  bool
     */
    public function isValid($value)
    {
        return strlen($value) <= $this->length;
    }

    /**
     * Get the validation error messages
     *
     * @return  array
     */
    public function getMessages()
    {
        return ["Length should not exceed $this->length!"];
    }
}
