<?php
/**
 * Part of Admin project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Luna\Admin\Form\Menus;

use Lyrasoft\Luna\Admin\Field\Menu\MenuModalField;
use Lyrasoft\Luna\Field\LunaFieldTrait;
use Lyrasoft\Luna\Helper\LunaHelper;
use Lyrasoft\Luna\Language\Locale;
use Lyrasoft\Warder\Helper\WarderHelper;
use Windwalker\Core\Form\AbstractFieldDefinition;
use Windwalker\Core\Language\Translator;
use Windwalker\Form\Form;
use Windwalker\Ioc;

/**
 * The GridDefinition class.
 *
 * @since  1.1
 */
class GridDefinition extends AbstractFieldDefinition
{
    use LunaFieldTrait;

    /**
     * Define the form fields.
     *
     * @param Form $form The Windwalker form object.
     *
     * @return  void
     */
    protected function doDefine(Form $form)
    {
        $langPrefix = LunaHelper::getLangPrefix();
        
        /*
         * Search Control
         * -------------------------------------------------
         * Add search fields as options, by default, model will search all columns.
         * If you hop that user can choose a field to search, change "display" to true.
         */
        $this->group('search', function (Form $form) use ($langPrefix) {
            // Search Field
            $this->list('field')
                ->label(__('phoenix.grid.search.field.label'))
                ->set('display', false)
                ->defaultValue('*')
                ->option(__('phoenix.core.all'), '*')
                ->option(__($langPrefix . 'menu.field.title'), 'menu.id')
                ->option(__($langPrefix . 'menu.field.title'), 'menu.title')
                ->option(__($langPrefix . 'menu.field.alias'), 'menu.alias');

            // Search Content
            $this->search('content')
                ->label(__('phoenix.grid.search.label'))
                ->placeholder(__('phoenix.grid.search.label'));
        });

        /*
         * Filter Control
         * -------------------------------------------------
         * Add filter fields to this section.
         * Remember to add onchange event => this.form.submit(); or Phoenix.post();
         *
         * You can override filter actions in MenusModel::configureFilters()
         */
        $this->group('filter', function (Form $form) use ($langPrefix) {
            // State
            $this->list('menu.state')
                ->label('State')
                ->addClass('has-select2')
                // Add empty option to support single deselect button
                ->option('', '')
                ->option(__($langPrefix . 'menu.filter.state.select'), '')
                ->option(__('phoenix.grid.state.published'), '1')
                ->option(__('phoenix.grid.state.unpublished'), '0')
                ->onchange('this.form.submit()');

            if (Locale::isEnabled()) {
                // Language
                $this->languageList('menu.language')
                    ->label(__($langPrefix . 'menu.field.language'))
                    ->class('has-select2')
                    ->option(__($langPrefix . 'field.language.select'), '')
                    ->option(__($langPrefix . 'field.language.all'), '*')
                    ->onchange('this.form.submit()');
            }
        });

        /*
         * This is batch form definition.
         * -----------------------------------------------
         * Every field is a table column.
         * For example, you can add a 'category_id' field to update item category.
         */
        $this->group('batch', function (Form $form) use ($langPrefix) {
            $input = Ioc::getInput();

            // Parent
            $this->add('parent_id', MenuModalField::class)
                ->label(__($langPrefix . 'category.field.parent'))
                ->class('col-md-12');

            if (Locale::isEnabled()) {
                // Language
                $this->languageList('language')
                    ->label(__($langPrefix . 'category.field.language'))
                    ->option(__($langPrefix . 'field.language.select'), '')
                    ->option(__($langPrefix . 'field.language.all'), '*');
            }

            if (WarderHelper::tableExists('users')) {
                // Author
                $this->userModal('created_by')
                    ->label(__($langPrefix . 'category.field.author'));
            }
        });
    }
}
