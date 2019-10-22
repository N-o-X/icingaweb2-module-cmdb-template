<?php

namespace Icinga\Module\Cmdb\Controllers;

use Icinga\Application\Config;
use Icinga\Module\Cmdb\Forms\SelectBackendForm;
use Icinga\Web\Controller;

class ConfigController extends Controller
{
    public function init()
    {
        $this->assertPermission('config/modules');

        parent::init();
    }

    public function backendAction()
    {
        $form = (new SelectBackendForm())
            ->setIniConfig(Config::module('cmdb'));

        $form->handleRequest();

        $this->view->tabs = $this->Module()->getConfigTabs()->activate('backend');
        $this->view->form = $form;
    }
}
