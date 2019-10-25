<?php

namespace Icinga\Module\Cmdb\Form;

use ipl\Web\Compat\CompatForm;

class SearchForm extends CompatForm
{
    protected $defaultAttributes = ['id' => 'cmdb-search-form' ];
    
    protected function assemble()
    {
        $this->addElement('text', 'search', [
            'placeholder' => 'Search...',
            //'class' => 'autosubmit'
            'id' => 'cmdb-search'
        ]);
    }
}
