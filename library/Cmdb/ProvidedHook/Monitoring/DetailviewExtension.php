<?php

namespace Icinga\Module\Cmdb\ProvidedHook\Monitoring;

use Icinga\Module\Cmdb\Common\Database;
use Icinga\Module\Cmdb\Widget\HostDetails;
use Icinga\Module\Monitoring\Hook\DetailviewExtensionHook;
use Icinga\Module\Monitoring\Object\MonitoredObject;
use ipl\Html\Html;
use ipl\Html\HtmlDocument;
use ipl\Sql\Select;

class DetailviewExtension extends DetailviewExtensionHook
{
    use Database;

    public function getHtmlForObject(MonitoredObject $object)
    {
        if ($object->getType() !== MonitoredObject::TYPE_HOST) {
            return null;
        }

        $select = (new Select())
            ->from('host')
            ->columns('*')
            ->where(['name = ?' => $object->name]);

        $host = $this->getDb()->select($select)->fetch();

        $html = new HtmlDocument();

        $html->add(Html::tag('h2', 'CMDB'));

        if ($host === false) {
            $html->add(Html::tag('p', 'There is no information on this host in our CMDB'));
        } else {
            $html->add(new HostDetails($host));
        }

        return $html;
    }
}
