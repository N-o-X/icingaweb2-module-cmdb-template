<?php

namespace Icinga\Module\Cmdb\Controllers;

use Icinga\Module\Cmdb\Common\Controller;

class ApiController extends Controller
{
    public function addconfigAction()
    {
        $this->export(['result' => "ok"]);
    }
}
