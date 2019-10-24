<?php

namespace Icinga\Module\Cmdb\Common;

use ipl\Html\Form;
use ipl\Sql\Connection;
use ipl\Sql\PaginationAdapter;
use ipl\Sql\Select;
use ipl\Web\Compat\CompatController;
use ipl\Web\Control\PaginationControl;
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

    public function createPaginationControl(Connection $db, Select $select)
    {
        $paginationControl = new PaginationControl(new PaginationAdapter($db, $select), Url::fromRequest());

        $this->params->shift($paginationControl->getPageParam());
        $this->params->shift($paginationControl->getPageSizeParam());

        return $paginationControl;
    }
}
