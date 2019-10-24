<?php

namespace Icinga\Module\Cmdb\Form;

use ipl\Web\Compat\CompatForm;

class SearchForm extends CompatForm
{
    protected function assemble()
    {
        $this->addElement('text', 'search', [
            'placeholder' => 'Search...',
        ]);
    }
}
