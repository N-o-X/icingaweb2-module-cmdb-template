<?php

namespace Icinga\Module\Cmdb\Form\Validator;

use ipl\Stdlib\Contract\ValidatorInterface;

class OSValidator implements ValidatorInterface
{
    /**
     * Get whether the given value is valid
     *
     * @param mixed $value
     *
     * @return  bool
     */
    public function isValid($value)
    {
        return $value === "Ubuntu";
    }

    /**
     * Get the validation error messages
     *
     * @return  array
     */
    public function getMessages()
    {
        return ["The OS has to be Ubuntu!"];
    }
}
