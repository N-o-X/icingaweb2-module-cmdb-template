<?php

namespace Icinga\Module\Cmdb\Form;

use ipl\Web\Compat\CompatForm;

class HelloForm extends CompatForm
{
    protected function assemble()
    {
        $this->addElement('text', 'name', [
            'label' => 'Name',
            'placeholder' => 'Please enter you name',
            'required' => true,
        ]);

        $this->addElement('submit', 'submit', [
            'label' => 'Get personal greeting',
        ]);
    }
}
