<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Administrator\View\Status;
\defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
/**
 * View to edit a foo.
 *
 * @since  __BUMP_VERSION__
 */
class HtmlView extends BaseHtmlView
{
    /**
     * The \JForm object
     *
     * @var  \JForm
     * @since
     */
    protected mixed $form;
    /**
     * The active item
     *
     * @var  object
     * @since
     */
    protected object $item;

    /**
     * Display the view.
     *
     * @param string $tpl The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  mixed  A string if successful, otherwise an Error object.
     * @throws \Exception
     * @since
     */
    public function display($tpl = null)
    {
        $this->form  = $this->get('Form');
        $this->item = $this->get('Item');
        $this->addToolbar();
        return parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @throws \Exception
     * @since   __BUMP_VERSION__
     */
    protected function addToolbar()
    {
        Factory::getApplication()->input->set('hidemainmenu', true);
        $isNew = ($this->item->id == 0);
        ToolbarHelper::title($isNew ? Text::_('COM_SCHOLARSHIPS_MANAGER_DEPARTMENT_NEW') : Text::_('COM_SCHOLARSHIPS_MANAGER_DEPARTMENT_EDIT'), 'address department');
        ToolbarHelper::apply('department.apply');
        ToolbarHelper::cancel('department.cancel', 'JTOOLBAR_CLOSE');
    }
}