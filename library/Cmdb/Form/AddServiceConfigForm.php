<?php

namespace Icinga\Module\Cmdb\Form;

use Icinga\Module\Monitoring\Backend\MonitoringBackend;
use ipl\Web\Compat\CompatForm;

class AddServiceConfigForm extends CompatForm
{
    protected $type;

    public function __construct($type = null)
    {
        $this->type = $type;
    }

    protected function getHostNames()
    {
        $hosts = MonitoringBackend::instance()->select()->from('hoststatus', [
            'host_name'
        ]);

        return $hosts->fetchColumn();
    }

    protected function assemble()
    {

        $hostNames = $this->getHostNames();

        $this->addElement('select', 'host', array(
            'label'        => 'Host',
            'multiOptions' => array_combine($hostNames, $hostNames),
            'required'     => true,
        ));

        $this->addElement('text', 'name', [
            'label'         => 'Service Name',
            'placeholder'   => 'Enter a service name',
            'required'      => true,
        ]);

        $this->addElement('select', 'type', [
            'label'        => 'Type',
            'multiOptions' => [
                'file' => 'Filesystems',
                'process' => 'Processes'
            ],
            'class'        => 'autosubmit',
            'required'     => true,
        ]);

        switch ($this->type) {
            case null:
            case 'file':
                $this->addElement('text', 'file-mountpoint', [
                    'label'         => 'Mount point',
                    'placeholder'   => 'Enter mount point',
                    'required'      => true,
                ]);
                break;
            case 'process':
                $this->addElement('text', 'process-name', [
                    'label'         => 'Process Name',
                    'placeholder'   => 'Enter a process name',
                    'required'      => true,
                ]);

                $this->addElement('text', 'process-args', [
                    'label'         => 'Process Arguments',
                    'placeholder'   => 'Enter process arguments',
                    'required'      => true,
                ]);
                break;
        }

        $this->addElement('submit', 'submit', [
            'label' => 'Add service',
        ]);
    }

}
