<?php

namespace Icinga\Module\Cmdb\Form;

use Icinga\Module\Cmdb\Common\Database;
use Icinga\Web\Notification;
use ipl\Web\Compat\CompatForm;

class EditHostForm extends CompatForm
{
    use Database;

    protected $host;

    public function __construct($host)
    {
        $this->populate($host);
        $this->host = $host;
    }

    protected function assemble()
    {
        $this->addElement('text', 'name', [
            'label' => 'Name',
            'placeholder' => 'Enter host name',
            'required' => true,
            'class' => 'name',
            'id' => 'name-field',
        ]);

        $this->addElement('text', 'os', [
            'label' => 'OS',
            'placeholder' => 'Enter host OS',
            'required' => true,
        ]);

        $this->addElement('text', 'created', [
            'label' => 'Created',
            'placeholder' => 'Choose date',
            'class' => 'cmdb-flatpickr',
        ]);

        $this->addElement('submit', 'submit', [
            'label' => 'Create host',
        ]);
    }

    /**
     * Will be called, if submitted and valid
     */
    public function onSuccess()
    {
        $values = $this->getValues();
        $this->getDb()->update('host', $values, ['id = ?' => $this->host->id]);
        Notification::success('Host updated');
    }
}
