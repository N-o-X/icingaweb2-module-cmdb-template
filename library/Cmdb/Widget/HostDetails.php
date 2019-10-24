<?php

namespace Icinga\Module\Cmdb\Widget;

use Icinga\Module\Cmdb\Hook\InfoHook;
use Icinga\Module\Cmdb\ProvidedHook\Cmdb\Info;
use ipl\Html\BaseHtmlElement;
use ipl\Html\Html;

class HostDetails extends BaseHtmlElement
{
    protected $tag = 'div';

    protected $host;

    public function __construct($host)
    {
        $this->host = $host;
    }

    public function assemble()
    {
        $this->add(Html::tag('div', 'Name'));
        $this->add(Html::tag('div', $this->host->name));

        $this->add(Html::tag('div', 'OS'));
        $this->add(Html::tag('div', $this->host->os));

        foreach (InfoHook::collect($this->host) as $key => $value) {
            $this->add(Html::tag('div', $key));
            $this->add(Html::tag('div', $value));
        }
    }
}
