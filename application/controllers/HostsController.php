<?php

namespace Icinga\Module\Cmdb\Controllers;

use GuzzleHttp\Psr7\ServerRequest;
use http\Url;
use Icinga\Module\Cmdb\Common\Controller;
use Icinga\Module\Cmdb\Common\Database;
use Icinga\Module\Cmdb\Form\AddHostForm;
use Icinga\Module\Cmdb\Widget\HostList;
use Icinga\Module\Monitoring\Web\Navigation\Action;
use Icinga\User;
use Icinga\Web\Form\Element\Button;
use ipl\Html\Html;
use ipl\Sql\Select;
use ipl\Sql\Where;
use ipl\Web\Compat\CompatController;
use ipl\Web\Widget\ActionLink;
use ipl\Web\Widget\ButtonLink;

class HostsController extends Controller
{
    use Database;

    public function indexAction()
    {
        $this->assertPermission('cmdb/hosts/view');

        $this->setTitle('Hosts');

        //$user = $this->Auth()->getUser();

        $select = (new Select())
            ->from('host')
            ->columns('*');

        $this->addControl($this->createPaginationControl($this->getDb(), $select));

        $hosts = $this->getDb()->select($select);

        /*foreach ($hosts as $host) {
            $hostElement = Html::tag('p', $host->name);
            $this->addContent($hostElement);
        }*/

        if ($this->hasPermission('cmdb/hosts/add')) {

            /**
             * Translation can be generation with 'icingacli translation refresh module cmdb de_DE'
             * Edited with a tool called "poedit"
             * And saved with 'icingacli translation compile module cmdb de_DE'
             */
            //mt('cmdb', 'Add Host'); // If $this->translate is not available
            $addHostButton = new ActionLink($this->translate('Add Host'), 'cmdb/hosts/add', 'plus', [
                'data-base-target' => '_next'
            ]);
            $this->addControl($addHostButton);
        }

        $hostList = new HostList($hosts);
        $this->addContent($hostList);
    }

    public function addAction()
    {
        $this->assertPermission('cmdb/hosts/add');

        $this->setTitle('Add host');

        $form = new AddHostForm();
        $form->handleRequest(ServerRequest::fromGlobals());

        $this->redirectForm($form, 'cmdb/hosts');

        $this->addContent($form);
    }
}
