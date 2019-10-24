<?php

namespace Icinga\Module\Cmdb\Hook;

use Icinga\Web\Hook;

abstract class InfoHook extends Hook
{
    /**
     * @param $host
     *
     * @return array Key-value pairs
     */
    abstract public function getInfo($host);

    /**
     * @param $host
     *
     * @return array
     */
    public static final function collect($host)
    {
        $info = [];

        foreach (Hook::all('cmdb/info') as $hook) {
            /** @var static $hook */
            $hookInfo = $hook->getInfo($host);

            if (! empty($hookInfo)) {
                $info += $hookInfo;
            }
        }

        return $info;
    }
}
