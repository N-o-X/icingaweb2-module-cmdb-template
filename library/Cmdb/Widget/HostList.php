<?php

namespace Icinga\Module\Cmdb\Widget;

use ipl\Html\BaseHtmlElement;
use ipl\Html\Html;
use ipl\Web\Url;
use ipl\Web\Widget\Link;

class HostList extends BaseHtmlElement
{
    protected $tag = 'table';

    protected $defaultAttributes = [
        'class' => 'common-table table-row-selectable',
        'data-base-target' => '_next',
    ];

    protected $hosts;

    public function __construct($hosts)
    {
        $this->hosts = $hosts;
    }

    public function createHeader()
    {
        $thead = Html::tag('thead');

        $theadRow = Html::tag('tr');

        $theadRow->add(Html::tag('th', 'Name'));
        $theadRow->add(Html::tag('th', 'OS'));

        $thead->add($theadRow);

        $this->add($thead);
    }

    public function createBody()
    {
        $tbody = Html::tag('tbody');

        foreach ($this->hosts as $host) {
            $hostRow =  Html::tag('tr');

            $hostLink = new Link($host->name, Url::fromPath('cmdb/host')->setParam('id', $host->id));

            $hostRow->add(Html::tag('td', $hostLink));
            $hostRow->add(Html::tag('td', $host->os));

            $tbody->add($hostRow);
        }

        $this->add($tbody);
    }

    /**
     * Will be executed automatically by the IPL/HTML library
     */
    protected function assemble()
    {
        $this->createHeader();
        $this->createBody();
    }
}
