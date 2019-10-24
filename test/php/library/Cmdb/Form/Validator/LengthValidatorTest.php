<?php

namespace Tests\Icinga\Module\Cmdb\Form\Validator;

use Icinga\Module\Cmdb\Form\Validator\LengthValidator;
use Icinga\Test\BaseTestCase;

class LengthValidatorTest extends BaseTestCase
{
    public function testWhetherLengthValidatorActsCorrect()
    {
        $validator = new LengthValidator(10);

        $this->assertEquals(
            true,
            $validator->isValid("1234567890"),
            'LengthValidator should accept strings exactly the limit'
        );

        $this->assertEquals(
            false,
            $validator->isValid("12345678901"),
            'LengthValidator should not accept strings over limit'
        );
    }
}
