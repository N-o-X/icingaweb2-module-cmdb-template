<?php

namespace Icinga\Module\Cmdb\Controllers;

use GuzzleHttp\Psr7\ServerRequest;
use Icinga\Module\Cmdb\Common\Database;
use Icinga\Module\Cmdb\Form\HelloForm;
use Icinga\Web\Session;
use ipl\Html\Html;
use ipl\Sql\Select;
use ipl\Web\Compat\CompatController;
use ipl\Web\Url;
use ipl\Web\Widget\ActionLink;
use React\ChildProcess\Process;
use React\EventLoop\ExtEventLoop;
use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\Server;

class TestController extends CompatController
{
    use Database;

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

    public function pingAction()
    {
        $loop = Factory::create();

        $process = new Process('ping -c 4 google.com');
        $process->start($loop);

        $pid = $process->getPid();

        $process->stdout->on('data', function ($chunk) use ($pid) {
            echo $chunk;
            $this->getDb()->insert('exec_log', ['pid' => $pid, 'log' => $chunk]);
        });

        $process->on('exit', function($exitCode, $termSignal) use ($pid) {
            $this->getDb()->insert('exec_log', ['pid' => $pid, 'log' => 'Process exited with code ' . $exitCode . PHP_EOL]);
        });

        $loop->run();

        $this->redirectNow(Url::fromPath('cmdb/test/viewping')->setParam('pid', $pid));
    }

    public function viewpingAction()
    {
        $pid = $this->params->getRequired('pid');
        $this->setTitle("Ping $pid");
        $this->setAutorefreshInterval(1);

        $select = (new Select())
            ->from('exec_log')
            ->columns('*')
            ->where(['pid = ?' => $pid]);

        $entries = $this->getDb()->select($select);

        foreach ($entries as $entry) {
            $this->addContent(Html::tag('div', $entry->log));
        }
    }
}
