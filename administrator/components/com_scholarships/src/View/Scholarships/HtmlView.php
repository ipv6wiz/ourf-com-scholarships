<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Administrator\View\Scholarships;
\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * View class for a list of foos.
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{
    protected $items;

    /**
     * Method to display the view.
     *
     * @param string $tpl A template file to load. [optional]
     *
     * @return  void
     *
     * @throws \Exception
     * @since   1.0.0
     */
    public function display($tpl = null): void
    {
        $this->items = $this->get('Items');
        if(!count($this->items) && $this->get('IsEmptyState')) {
            $this->setLayout('emptystate');
        }
        $this->addToolbar();
        parent::display($tpl);
    }

    protected function addToolbar()
    {
        // Get the toolbar object instance
        $toolbar = Toolbar::getInstance('toolbar');
        ToolbarHelper::title(Text::_('COM_SCHOLARSHIPS_MANAGER_SCHOLARSHIPS'), 'address scholarship');
        $toolbar->addNew('scholarship.add');
    }
}