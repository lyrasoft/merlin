<?php
/**
 * Part of Luna project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Luna\Admin\Field\Contact;

use Lyrasoft\Luna\Helper\LunaHelper;
use Lyrasoft\Luna\Table\LunaTable;
use Phoenix\Field\ModalField;

/**
 * The ContactModalField class.
 *
 * @since  1.0
 */
class ContactModalField extends ModalField
{
    /**
     * Property table.
     *
     * @var  string
     */
    protected $table = LunaTable::CONTACTS;

    /**
     * Property view.
     *
     * @var  string
     */
    protected $view = 'contacts';

    /**
     * Property titleField.
     *
     * @var  string
     */
    protected $titleField = 'title';

    /**
     * Property keyField.
     *
     * @var  string
     */
    protected $keyField = 'id';

    /**
     * buildInput
     *
     * @param array $attrs
     *
     * @return  string
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function buildInput($attrs)
    {
        $this->package = LunaHelper::getPackage()->getCurrentPackage()->getName();

        return parent::buildInput($attrs);
    }
}
