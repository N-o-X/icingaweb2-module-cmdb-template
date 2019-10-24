<?php

namespace Icinga\Module\Cmdb\Clicommands;

use Icinga\Cli\Command;
use Icinga\Module\Cmdb\Common\Database;
use ipl\Sql\Select;


class TestCommand extends Command
{
    use Database;

    /**
     * Can be called in CLI via "icingacli cmdb test hello"
     */
    public function helloAction()
    {
        $select = (new Select())
            ->columns('*')
            ->from('host');

        $hosts = $this->getDb()->select($select);

        foreach ($hosts as $host) {
            echo "$host->name\n";
        }
    }
}
