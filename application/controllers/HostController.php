<?php

namespace Icinga\Module\Cmdb\Controllers;

use GuzzleHttp\Psr7\ServerRequest;
use Icinga\Exception\NotFoundError;
use Icinga\Module\Cmdb\Common\Controller;
use Icinga\Module\Cmdb\Common\Database;
use Icinga\Module\Cmdb\Form\DeleteHostForm;
use Icinga\Module\Cmdb\Form\EditHostForm;
use Icinga\Module\Cmdb\Widget\HostDetails;
use Icinga\Web\Widget\Tab;
use ipl\Sql\Select;
use ipl\Sql\Where;
use ipl\Web\Compat\CompatController;
use ipl\Web\Url;
use ipl\Web\Widget\ActionLink;

class HostController extends Controller
{
    use Database;

    protected $host;

    public function init()
    {
        $id = $this->params->getRequired('id');

        $select = (new Select())
            ->from('host')
            ->columns('*')
            ->where(['id = ?' => $id]);

        $host = $this->getDb()->select($select)->fetch();

        if ($host === false) {
            throw new NotFoundError('Host not found');
        }

        $this->host = $host;
    }

    public function addTabs($active)
    {
        $this->getTabs()->add('details', new Tab([
            'title' => 'Details',
            'url' => Url::fromPath('cmdb/host')->setParam('id', $this->host->id),
        ]));

        $this->getTabs()->add('edit', new Tab([
            'title' => 'Edit',
            'url' => Url::fromPath('cmdb/host/edit')->setParam('id', $this->host->id),
        ]));

        $this->getTabs()->add('delete', new Tab([
            'title' => 'Delete',
            'url' => Url::fromPath('cmdb/host/delete')->setParam('id', $this->host->id),
        ]));

        $this->getTabs()->activate($active);
    }

    public function indexAction()
    {
        $this->assertPermission('cmdb/hosts/view');

        //$this->setTitle(sprintf("Host: %s", $this->host->name));
        $this->addTabs('details');

        if ($this->hasPermission('cmdb/hosts/delete')) {
            $deleteHostButton = new ActionLink(
                'Delete Host',
                Url::fromPath('cmdb/host/delete')->setParam('id', $this->host->id),
                'trash'
            );
            $this->addControl($deleteHostButton);
        }

        if ($this->hasPermission('cmdb/hosts/edit')) {
            $editHostButton = new ActionLink(
                'Edit Host',
                Url::fromPath('cmdb/host/edit')->setParam('id', $this->host->id),
                'wrench'
            );
            $this->addControl($editHostButton);
        }

        $hostDetails = new HostDetails($this->host);
        $this->addContent($hostDetails);
    }

    public function deleteAction()
    {
        $this->assertPermission('cmdb/hosts/delete');

        //$this->setTitle(sprintf("Delete Host: %s", $this->host->name));
        $this->addTabs('delete');

        $form = new DeleteHostForm($this->host);
        $form->handleRequest(ServerRequest::fromGlobals());

        $this->redirectForm($form, 'cmdb/hosts');

        $this->addContent($form);
    }

    public function editAction()
    {
        $this->assertPermission('cmdb/hosts/edit');

        //$this->setTitle(sprintf("Edit Host: %s", $this->host->name));
        $this->addTabs('edit');

        $form = new EditHostForm($this->host);
        $form->handleRequest(ServerRequest::fromGlobals());

        $this->redirectForm($form, Url::fromPath('cmdb/host')->setParam('id', $this->host->id));

        $this->addContent($form);
    }
}
