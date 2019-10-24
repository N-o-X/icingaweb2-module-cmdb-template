<?php

namespace Icinga\Module\Cmdb\Controllers;

use Icinga\Module\Cmdb\Common\Controller;
use Icinga\Module\Cmdb\Common\Database;
use ipl\Html\Html;
use ipl\Sql\Expression;
use ipl\Sql\Select;

class StatsController extends Controller
{
    use Database;

    public function hostcountAction()
    {
        $this->setAutorefreshInterval(10);

        $select = (new Select())
            ->from('host')
            ->columns(['count' => new Expression('COUNT(*)'), 'os'])
            ->groupBy('os');

        $osCounts = $this->getDb()->select($select);

        foreach ($osCounts as $osCount) {
            $this->addContent(Html::tag('p', ['class' => 'stats-count'], "$osCount->os: $osCount->count"));
        }
    }
}
