<?php

namespace Icinga\Module\Cmdb\ProvidedHook\Cmdb;

use Icinga\Exception\ConfigurationError;
use Icinga\Module\Cmdb\Hook\InfoHook;
use Icinga\Module\Monitoring\Backend\MonitoringBackend;
use Icinga\Module\Monitoring\Object\Host;

class Info extends InfoHook
{
    /**
     * @param $host
     *
     * @return array Key-value pairs
     *
     * @throws ConfigurationError
     */
    public function getInfo($host)
    {
        $icingaHost = new Host(MonitoringBackend::instance(), $host->name);

        if ($icingaHost->fetch()) {
            return ['State' => $icingaHost->state];
        }
    }
}
