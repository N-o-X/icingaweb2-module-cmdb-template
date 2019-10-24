<?php

namespace Icinga\Module\Cmdb\Common;

use ipl\Html\Form;
use ipl\Web\Compat\CompatController;
use ipl\Web\Url;

abstract class Controller extends CompatController
{
    /**
     * @param $form Form
     * @param $url Url|string
     */
    protected function redirectForm($form, $url)
    {
        if ($form->hasBeenSubmitted() && $form->isValid()) {
            $this->redirectNow($url);
        }
    }
}
