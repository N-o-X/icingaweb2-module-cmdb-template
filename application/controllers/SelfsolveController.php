<?php

namespace Icinga\Module\Cmdb\Controllers;

use GuzzleHttp\Psr7\ServerRequest;
use Icinga\Module\Cmdb\Common\Controller;
use Icinga\Module\Cmdb\Common\Database;
use Icinga\Module\Cmdb\Form\AddServiceConfigForm;
use Icinga\Module\Cmdb\Widget\SelfSolveConfigList;
use ipl\Sql\Select;
use ipl\Web\Widget\ActionLink;

class SelfsolveController extends Controller{

    use Database;

    public function indexAction()
    {
       // $this->assertPermission('cmdb/selfsolves/view');

        $this->setTitle('SelfSolve');

        $select = (new Select())
            ->from('config')
            ->columns('*');

        $configs = $this->getDb()->select($select);

        $addConfigButton = new ActionLink($this->translate('Add Config','Context: Add new configuration which will be stored in the mysqdl config tables.'),'cmdb/selfsolve/add','plus',[
            'data-base-target' => '_next'
        ]);

        $this->addControl($addConfigButton);

        $configList = new SelfSolveConfigList($configs);
        $this->addContent($configList);

    }

    public function addAction()
    {
        $this->setTitle($this->translate('Add config'));

        $request = ServerRequest::fromGlobals();
        $params = $request->getParsedBody();
        $form = new AddServiceConfigForm(isset($params['type']) ? $params['type'] : '');
        $form->handleRequest($request);

        $this->redirectForm($form, 'cmdb/selfsolve');

        $this->addContent($form);
    }
}
