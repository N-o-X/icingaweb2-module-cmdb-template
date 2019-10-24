<?php

namespace Icinga\Module\Cmdb\Widget;

use ipl\Html\BaseHtmlElement;
use ipl\Html\Html;
use ipl\Web\Url;
use ipl\Web\Widget\Link;

class SelfSolveConfigList extends BaseHtmlElement{

    protected $tag = 'table';

    protected $defaulAttributes = [
        'class' => 'common-table table-row-selectable',
        'data-base-target' => '_next'
    ];

    protected $configs;

    public function __construct($configs)
    {
        $this->configs = $configs;
    }

    public function createHeader()
    {
        $th = Html::tag('thead');
    
        $thr = Html::tag('tr');
    
        $thr->add(Html::tag('th','hostname'));
        $thr->add(Html::tag('th','servicename'));
        $thr->add(Html::tag('th','object'));

        $th->add($thr);

        $this->add($th);
    }

    public function createBody()
    {
        $tbody = Html::tag('tbody');

        foreach ($this->configs as $config) {
            $configRow = Html::tag('tr');

            $configLink = new Link(
                $config->hostname, Url::fromPath('cmdb/config')->setParams(['id' => $config->id, 'type' => $config->type]));

            $configRow->add(Html::tag('td', $configLink));
            $configRow->add(Html::tag('td', $config->servicename));
            $configRow->add(Html::tag('td', $config->monitorobject));

            $tbody->add($configRow);
        }

        $this->add($tbody);
    }

    protected function assemble()
    {
        $this->createHeader();
        $this->createBody();
    }
}