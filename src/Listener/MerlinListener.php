<?php
/**
 * Part of phoenix project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Luna\Listener;

use Lyrasoft\Luna\Helper\LunaHelper;
use Lyrasoft\Luna\LunaPackage;
use Phoenix\DataMapper\DataMapperResolver;
use Phoenix\Form\FieldDefinitionResolver;
use Phoenix\Record\RecordResolver;
use Windwalker\Core\Application\WebApplication;
use Windwalker\Core\Renderer\BladeRenderer;
use Windwalker\Core\View\BladeHtmlView;
use Windwalker\Event\Event;
use Windwalker\Utilities\Queue\Priority;
use Windwalker\Utilities\Reflection\ReflectionHelper;

/**
 * The LunaListener class.
 *
 * @since  {DEPLOY_VERSION}
 */
class LunaListener
{
	/**
	 * Property package.
	 *
	 * @var  LunaPackage
	 */
	protected $luna;

	/**
	 * UserListener constructor.
	 *
	 * @param LunaPackage $luna
	 */
	public function __construct(LunaPackage $luna = null)
	{
		$this->luna = $luna ? : LunaHelper::getPackage();
	}

	/**
	 * onAfterRouting
	 *
	 * @param Event $event
	 *
	 * @return  void
	 */
	public function onAfterRouting(Event $event)
	{
		/** @var WebApplication $app */
		$app     = $event['app'];
		$package = $app->getPackage();

		// In Warder
		if ($this->luna->isEnabled())
		{
			RecordResolver::addNamespace(ReflectionHelper::getNamespaceName($this->luna) . '/Admin/Record', Priority::LOW);
			DataMapperResolver::addNamespace(ReflectionHelper::getNamespaceName($this->luna) . '/Admin/DataMapper', Priority::LOW);
		}

		// Frontend
		if ($this->luna->isFrontend())
		{
			$package->getMvcResolver()
				->addNamespace(ReflectionHelper::getNamespaceName($this->luna));

			FieldDefinitionResolver::addNamespace((ReflectionHelper::getNamespaceName($this->luna) . '\Form'));
		}
		elseif ($this->luna->isAdmin())
		{
			$package->getMvcResolver()
				->addNamespace(ReflectionHelper::getNamespaceName($this->luna) . '\Admin');

			FieldDefinitionResolver::addNamespace(ReflectionHelper::getNamespaceName($this->luna) . '\Admin\Form');
		}
	}

	/**
	 * onViewBeforeRender
	 *
	 * @param Event $event
	 *
	 * @return  void
	 */
	public function onViewBeforeRender(Event $event)
	{
		$view = $event['view'];

		/**
		 * @var BladeHtmlView $view
		 * @var BladeRenderer $renderer
		 */
		$name = $view->getName();
		$renderer = $view->getRenderer();

		$app = $view->getPackage()->app;

		// Prepare View data
		if ($this->luna->isFrontend())
		{
			// Extends
			$view['lunaExtends'] = $this->luna->get('frontend.view.extends', '_global.html');
			$view['lunaPrefix'] = $this->luna->get('frontend.language.prefix', 'warder.');
			$view['warder'] = $this->luna;

			// Paths
//			$renderer->addPath(WARDER_SOURCE . '/Templates/' . $name . '/' . $app->get('language.locale'), Priority::LOW - 25);
//			$renderer->addPath(WARDER_SOURCE . '/Templates/' . $name . '/' . $app->get('language.default'), Priority::LOW - 25);
			$renderer->addPath(LUNA_SOURCE . '/Templates/' . $name, Priority::LOW - 25);
		}
		elseif ($this->luna->isAdmin())
		{
			// Extends
			$view['lunaExtends'] = $this->luna->get('admin.view.extends', '_global.html');
			$view['lunaPrefix'] = $this->luna->get('admin.language.prefix', 'warder.');
			$view['warder'] = $this->luna;

			// Paths
//			$renderer->addPath(WARDER_SOURCE_ADMIN . '/Templates/' . $name . '/' . $app->get('language.locale'), Priority::LOW - 25);
//			$renderer->addPath(WARDER_SOURCE_ADMIN . '/Templates/' . $name . '/' . $app->get('language.default'), Priority::LOW - 25);
			$renderer->addPath(LUNA_SOURCE_ADMIN . '/Templates/' . $name, Priority::LOW - 25);
		}
	}
}
