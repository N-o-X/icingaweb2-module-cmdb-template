<?php

namespace Icinga\Module\Cmdb\Controllers;

use ipl\Html\Html;
use ipl\Web\Compat\CompatController;

/**
 * Icinga Web 2 will always use the index controller and index action, if no controller is provided via url.
 * The same applies for url that only provide a controller
 */

class IndexController extends CompatController
{
    public function indexAction()
    {
        $test = Html::tag('p', 'It works!');
        $this->addContent($test);
    }
}
