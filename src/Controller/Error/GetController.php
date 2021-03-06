<?php
/**
 * Part of Front project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Luna\Controller\Error;

use Lyrasoft\Luna\Repository\ErrorModel;
use Phoenix\Controller\Display\ItemDisplayController;
use Windwalker\Core\Repository\Repository;

/**
 * The GetController class.
 *
 * @since  1.0
 */
class GetController extends ItemDisplayController
{
    /**
     * Property name.
     *
     * @var  string
     */
    protected $name = 'error';

    /**
     * Property itemName.
     *
     * @var  string
     */
    protected $itemName = 'error';

    /**
     * Property listName.
     *
     * @var  string
     */
    protected $listName = 'error';

    /**
     * prepareExecute
     *
     * @return  void
     * @throws \Exception
     */
    protected function prepareExecute()
    {
        parent::prepareExecute();

        if ($this->format === 'html') {
            // Keep HTTP status text as default if in HTML
            $this->response = $this->response->withStatus($this->response->getStatusCode());

            $this->view['exception'] = $this->input->getRaw('exception');
        } else {
            $exception = $this->input->getRaw('exception');

            $this->view->getData()->load([
                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * prepareModelState
     *
     * @param   Repository $repository
     *
     * @return  void
     */
    protected function prepareModelState(Repository $repository)
    {
        parent::prepareModelState($repository);
    }

    /**
     * postExecute
     *
     * @param mixed $result
     *
     * @return  mixed
     */
    protected function postExecute($result = null)
    {
        return parent::postExecute($result);
    }
}
