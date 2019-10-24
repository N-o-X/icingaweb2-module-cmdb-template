<?php

namespace Icinga\Module\Cmdb\Form;

use Icinga\Module\Monitoring\Backend\MonitoringBackend;
use ipl\Web\Compat\CompatForm;

class AddServiceConfigForm extends CompatForm
{
    protected function getHostNames()
    {
        $hosts = MonitoringBackend::instance()->select()->from('hoststatus', [
            'host_name'
        ]);

        return $hosts->fetchColumn();
    }

    protected function assemble()
    {
        
        $this->addElement('select', 'host', array(
            'label'        => 'Host',
            'multiOptions' => $this->getHostNames(),
            'required'     => true,
        ));

        $this->addElement('text', 'name', [
            'label' => 'Service Name',
            'placeholder' => 'Enter a service name',
            'required' => true,
        ]);

        $this->addElement('select', 'type', array(
            'label'        => 'Type',
            'multiOptions' => ['Filesystems', 'Processes'],
            'required'     => true,
        ));

        $this->addElement('submit', 'submit', [
            'label' => 'Add service',
        ]);
    }
}
