<?php

namespace Icinga\Module\Cmdb\Form;

use Icinga\Module\Cmdb\Common\Database;
use ipl\Html\Html;
use ipl\Web\Compat\CompatForm;

class DeleteHostForm extends CompatForm
{
    use Database;

    protected $host;

    public function __construct($host)
    {
        $this->host = $host;
    }

    protected function assemble()
    {
        $this->add(Html::tag('p', sprintf("Please confirm deletion of host %s", $this->host->name)));

        $this->addElement('submit', 'submit', [
           'label' => 'Delete Host'
        ]);
    }

    public function onSuccess()
    {
        $this->getDb()->delete('host', ['id = ?' => $this->host->id]);
    }
}
