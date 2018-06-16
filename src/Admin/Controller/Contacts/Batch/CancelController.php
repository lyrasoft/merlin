<?php
/**
 * Part of Luna project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Lyrasoft\Luna\Admin\Controller\Contacts\Batch;

use Lyrasoft\Luna\Helper\LunaHelper;
use Phoenix\Controller\Batch\AbstractTrashController;

/**
 * The CancelController class.
 *
 * @since  1.0
 */
class CancelController extends AbstractTrashController
{
    /**
     * Property action.
     *
     * @var  string
     */
    protected $action = 'cancel';

    /**
     * A hook before main process executing.
     *
     * @return  void
     * @throws \ReflectionException
     */
    protected function prepareExecute()
    {
        $this->langPrefix = LunaHelper::getLangPrefix();

        parent::prepareExecute();
    }
}
