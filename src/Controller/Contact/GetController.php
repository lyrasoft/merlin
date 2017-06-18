<?php
/**
 * Part of Luna project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Luna\Controller\Contact;

use Lyrasoft\Luna\Model\ContactModel;
use Lyrasoft\Luna\View\Contact\ContactHtmlView;
use Phoenix\Controller\Display\DisplayController;
use Phoenix\Controller\Display\EditDisplayController;
use Windwalker\Core\Model\ModelRepository;
use Windwalker\Core\Security\Exception\UnauthorizedException;
use Windwalker\Core\View\AbstractView;
use Windwalker\Data\DataInterface;
use Windwalker\Router\Exception\RouteNotFoundException;

/**
 * The GetController class.
 * 
 * @since  1.0
 */
class GetController extends EditDisplayController
{
	/**
	 * The default Model.
	 *
	 * If set model name here, controller will get model object by this name.
	 *
	 * @var  ContactModel
	 */
	protected $model = 'Contact';

	/**
	 * Main View.
	 *
	 * If set view name here, controller will get model object by this name.
	 *
	 * @var  ContactHtmlView
	 */
	protected $view = 'Contact';

	/**
	 * A hook before main process executing.
	 *
	 * @return  void
	 */
	protected function prepareExecute()
	{
		parent::prepareExecute();
	}

	/**
	 * Prepare view and default model.
	 *
	 * You can configure default model state here, or add more sub models to view.
	 * Remember to call parent to make sure default model already set in view.
	 *
	 * @param AbstractView    $view  The view to render page.
	 * @param ModelRepository $model The default mode.
	 *
	 * @return  void
	 */
	protected function prepareViewModel(AbstractView $view, ModelRepository $model)
	{
		/**
		 * @var $view  ContactHtmlView
		 * @var $model ContactModel
		 */
		parent::prepareViewModel($view, $model);

		$model['load.conditions'] = null;
	}

	/**
	 * A hook after main process executing.
	 *
	 * @param mixed $result The result content to return, can be any value or boolean.
	 *
	 * @return  mixed
	 */
	protected function postExecute($result = null)
	{
		return parent::postExecute($result);
	}
}
