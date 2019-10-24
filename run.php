<?php

/** @var \Icinga\Application\Modules\Module $this */

require_once 'vendor/autoload.php';

$this->provideHook('Monitoring/DetailviewExtension');
$this->provideHook('Cmdb/Info');
