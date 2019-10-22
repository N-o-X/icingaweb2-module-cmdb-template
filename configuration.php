<?php

/** @var \Icinga\Application\Modules\Module $this */

$this->provideConfigTab('backend', [
    'title' => $this->translate('Configure the database backend'),
    'label' => $this->translate('Backend'),
    'url'   => 'config/backend'
]);
