<?php

namespace Icinga\Module\Cmdb\Common;

use GuzzleHttp\Psr7\ServerRequest;
use Icinga\Util\Json;
use ipl\Html\Form;
use ipl\Sql\Connection;
use ipl\Sql\PaginationAdapter;
use ipl\Sql\Select;
use ipl\Web\Compat\CompatController;
use ipl\Web\Control\PaginationControl;
use ipl\Web\Url;

abstract class Controller extends CompatController
{
    /** @var string Requested output format */
    protected $format;

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

    public function preDispatch()
    {
        // Shift format parameter early because our filter implementation expects all params in $this->params to be
        // valid filter columns
        $this->format = $this->params->shift('format');
    }

    /**
     * @param iterable $data
     */
    protected function export($data)
    {
        $accept = $this->getRequest()->getHeader('Accept');

        switch (true) {
            case $accept === 'application/json' || $this->format === 'json':
                $response = $this->getResponse();
                $response
                    ->setHeader('Content-Type', 'application/json')
                    ->setHeader('Cache-Control', 'no-store')
                    ->setHeader(
                        'Content-Disposition',
                        'inline; filename=' . $this->getRequest()->getActionName() . '.json'
                    )
                    ->setBody(Json::sanitize($data))
                    ->sendResponse();

                exit;
            default:
                break;
        }
    }
}
