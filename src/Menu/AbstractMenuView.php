<?php
/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2019 .
 * @license    LGPL-2.0-or-later
 */

namespace Lyrasoft\Luna\Menu;

use Phoenix\Html\MenuHelper;
use Windwalker\Core\Event\EventDispatcher;
use Windwalker\Core\Form\CoreFieldDefinitionInterface;
use Windwalker\Core\Form\CoreFieldDefinitionTrait;
use Windwalker\Core\Router\RouteBuilderInterface;
use Windwalker\DI\Annotation\Inject;
use Windwalker\Event\DispatcherAwareTrait;
use Windwalker\Event\DispatcherInterface;
use Windwalker\Form\Form;

/**
 * The AbstractView class.
 *
 * @since  1.7
 */
abstract class AbstractMenuView implements
    CoreFieldDefinitionInterface,
    DispatcherInterface
{
    use CoreFieldDefinitionTrait;
    use DispatcherAwareTrait;

    public const NO_LINK = '__NO_LINK__';

    /**
     * Property tabs.
     *
     * @var array
     */
    protected $tabs = [];

    /**
     * Property dispatcher.
     *
     * @Inject()
     *
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * Property menuHelper.
     *
     * @Inject()
     *
     * @var MenuHelper
     */
    protected $menuHelper;

    /**
     * getName
     *
     * @return  string
     *
     * @since  1.7
     */
    abstract public static function getName(): string;

    /**
     * getTitle
     *
     * @return  string
     *
     * @since  1.7
     */
    public static function getTitle(): string
    {
        return __('luna.menu.view.' . static::getName() . '.title');
    }

    /**
     * getDescription
     *
     * @return  string
     *
     * @since  1.7
     */
    public static function getDescription(): string
    {
        return __('luna.menu.view.' . static::getName() . '.desc');
    }

    /**
     * getGroup
     *
     * @return  string
     *
     * @since  1.7
     */
    public static function getGroup(): string
    {
        return 'core';
    }

    /**
     * Define the form fields.
     *
     * @param Form $form The Windwalker form object.
     *
     * @return  void
     */
    protected function doDefine(Form $form)
    {
        $this->group('variables', function (Form $form) {
            $this->defineVariables($form);
        });

        $this->group('params', function (Form $form) {
            $this->defineParams($form);
        });

        $this->triggerEvent('onMenuDefineFormField', [
            'form' => $form,
            'menu' => $this
        ]);
    }

    /**
     * defineRoute
     *
     * @param Form $form
     *
     * @return  void
     *
     * @since  1.7
     */
    abstract protected function defineVariables(Form $form): void;

    /**
     * You must use tab('name', function () { ... }) to wrap your fields.
     *
     * @param Form $form
     *
     * @return  void
     *
     * @since  1.7
     */
    abstract protected function defineParams(Form $form): void;

    /**
     * tab
     *
     * @param string   $fieldset
     * @param string   $title
     * @param callable $callback
     *
     * @return  static
     *
     * @since  1.7
     */
    public function tab(string $fieldset, ?string $title, callable $callback): self
    {
        if (!$title) {
            $title = __('luna.menu.view.params.fieldset.' . $fieldset);
        }

        $this->tabs[$fieldset] = [
            'title' => $title
        ];

        $this->fieldset($fieldset, $callback);

        return $this;
    }

    /**
     * Method to get property Tabs
     *
     * @return  array
     *
     * @since  1.7
     */
    public function getTabs(): array
    {
        return $this->tabs;
    }

    /**
     * prepareVariablesStore
     *
     * @param array $variables
     *
     * @return  void
     *
     * @since  1.7
     */
    public function prepareVariablesForm(array &$variables): void
    {
        //
    }

    /**
     * prepareVariablesStore
     *
     * @param array $variables
     *
     * @return  void
     *
     * @since  1.7
     */
    public function prepareVariablesStore(array &$variables): void
    {
        //
    }

    /**
     * route
     *
     * @param RouteBuilderInterface $router
     * @param array                 $variables
     * @param array                 $params
     *
     * @return  string
     *
     * @since  1.7
     */
    abstract public function route(RouteBuilderInterface $router, array $variables, array $params): string;

    /**
     * isActive
     *
     * @param array $variables
     * @param array $params
     *
     * @return  bool
     *
     * @since  1.7
     */
    abstract public function isActive(array $variables, array $params): bool;
}
