<?php

/** @var \Icinga\Application\Modules\Module $this */

$this->provideConfigTab('backend', [
    'title' => $this->translate('Configure the database backend'),
    'label' => $this->translate('Backend'),
    'url'   => 'config/backend'
]);

$this->menuSection('Hello', [
   'icon' => 'megaphone',
   'url' => 'cmdb/test/hello'
]);

$cmdbSection = $this->menuSection('CMDB', [
    'icon' => 'wrench',
    'priority' => 0,
]);

$cmdbSection->add('Hosts', [
    'url' => 'cmdb/hosts',
    'priority' => 1
]);

$cmdbSection->add('Hello', [
    'url' => 'cmdb/test/hello',
    'priority' => 2
]);

$this->providePermission( 'cmdb/hosts/*', 'Allows to do everything');
$this->providePermission( 'cmdb/hosts/view', 'Allows to view hosts');
$this->providePermission( 'cmdb/hosts/add', 'Allows to add hosts');
$this->providePermission( 'cmdb/hosts/edit', 'Allows to edit hosts');
$this->providePermission( 'cmdb/hosts/delete', 'Allows to delete hosts');

$this->provideRestriction('cmdb/hosts/name', '');

$dashboard = $this->dashboard('CMDB',  [
    'priority' => '0',
]);

$dashboard->add('Host List', 'cmdb/hosts', 0);
$dashboard->add('Host OS Count', 'cmdb/stats/hostcount', 1);

$this->provideJsFile('vendor/flatpickr.min.js');
$this->provideCssFile('vendor/flatpickr.min.css');
