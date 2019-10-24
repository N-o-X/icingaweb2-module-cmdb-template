<?php

namespace Icinga\Module\Cmdb\Controllers;

use GuzzleHttp\Psr7\ServerRequest;
use Icinga\Module\Cmdb\Form\HelloForm;
use ipl\Html\Html;
use ipl\Web\Compat\CompatController;
use ipl\Web\Url;
use ipl\Web\Widget\ActionLink;

class TestController extends CompatController
{
    public function helloAction()
    {
        $this->setTitle('Hello');

        $greetingButton = new ActionLink('Get personal greeting', 'cmdb/test/newhello', 'wrench', [
            'class' => 'button',
        ]);
        $this->addControl($greetingButton);

        $name = $this->params->get('name', 'world');

        $hello = Html::tag('p', "Hello $name!");
        $this->addContent($hello);
    }

    /**
     * Action name must always be lower case
     */
    public function newhelloAction()
    {
        $this->setTitle('Personal greeting');

        $form = new HelloForm();
        $form->handleRequest(ServerRequest::fromGlobals());

        if ($form->hasBeenSubmitted() && $form->isValid()) {
            $this->redirectNow(Url::fromPath('cmdb/test/hello')->setParam('name', $form->getValue('name')));
        }


        $this->addContent($form);
    }
}
