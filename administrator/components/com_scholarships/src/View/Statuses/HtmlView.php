<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Administrator\View\Statuses;
\defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use OURF\Component\Scholarships\Administrator\Extension\ScholarshipsComponent;
use OURF\Component\Scholarships\Administrator\Helper\ScholarshipHelper;

/**
 * View class for a list of Scholarship Statuses.
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{
    protected $items;

    /**
     * The pagination object
     *
     * @var  \JPagination
     * @since
     */
    protected $pagination;

    /**
     * The model state
     *
     * @var  \JObject
     * @since
     */
    protected $state;

    /**
     * Form object for search filters
     *
     * @var  \JForm
     * @since
     */
    public $filterForm;

    /**
     * The active search filters
     *
     * @var  array
     * @since
     */
    public $activeFilters;

    /**
     * All transition, which can be executed of one if the items
     *
     * @var  array
     * @since
     */
    protected $transitions = [];

    /**
     * Is this view an Empty State
     *
     * @var  boolean
     * @since 4.0.0
     */
    private $isEmptyState = false;

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
        $this->items         = $this->get('Items');
        $this->pagination    = $this->get('Pagination');
        $this->state         = $this->get('State');
        $this->filterForm    = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');
        $workflow_enabled = ComponentHelper::getParams('com_scholarships')->get('workflow_enabled');
        // echo '<pre>Workflow Enabled : '.$workflow_enabled.'</pre><br>';
        if(!count($this->items) && $this->get('IsEmptyState')) {
            $this->setLayout('emptystate');
        }
        if ($workflow_enabled)
        {
            PluginHelper::importPlugin('workflow');

            $this->transitions = $this->get('Transitions');
        }
        $this->addToolbar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @throws \Exception
     * @since   1.6
     */
    protected function addToolbar()
    {
        $canDo = ScholarshipHelper::getActions('com_scholarships', 'category', $this->state->get('filter.category_id'));
        $user  = Factory::getApplication()->getIdentity();

        // Get the toolbar object instance
        $toolbar = Toolbar::getInstance('toolbar');

        ToolbarHelper::title(Text::_('COM_SCHOLARSHIPS_MANAGER_STATUSES'), 'address scholarship');

        if ($canDo->get('core.create') || \count($user->getAuthorisedCategories('com_scholarships', 'core.create')) > 0)
        {
            $toolbar->addNew('status.add');
        }

        if (!$this->isEmptyState && ($canDo->get('core.edit.state') || \count($this->transitions)))
        {
            $dropdown = $toolbar->dropdownButton('status-group')
                ->text('JTOOLBAR_CHANGE_STATUS')
                ->toggleSplit(false)
                ->icon('icon-ellipsis-h')
                ->buttonClass('btn btn-action')
                ->listCheck(true);

            $childBar = $dropdown->getChildToolbar();

            if (\count($this->transitions))
            {
                $childBar->separatorButton('transition-headline')
                    ->text('COM_SCHOLARSHIPS_RUN_TRANSITIONS')
                    ->buttonClass('text-center py-2 h3');

                $cmd = "Joomla.submitbutton('status.runTransition');";
                $messages = "{error: [Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')]}";
                $alert = 'Joomla.renderMessages(' . $messages . ')';
                $cmd   = 'if (document.adminForm.boxchecked.value == 0) { ' . $alert . ' } else { ' . $cmd . ' }';

                foreach ($this->transitions as $transition)
                {
                    $childBar->standardButton('transition')
                        ->text($transition['text'])
                        ->buttonClass('transition-' . (int) $transition['value'])
                        ->icon('icon-project-diagram')
                        ->onclick('document.adminForm.transition_id.value=' . (int) $transition['value'] . ';' . $cmd);
                }

                $childBar->separatorButton('transition-separator');
            }

            if ($canDo->get('core.edit.state'))
            {
                $childBar->publish('status.publish')->listCheck(true);

                $childBar->unpublish('status.unpublish')->listCheck(true);

                $childBar->standardButton('featured')
                    ->text('JFEATURE')
                    ->task('status.featured')
                    ->listCheck(true);

                $childBar->standardButton('unfeatured')
                    ->text('JUNFEATURE')
                    ->task('status.unfeatured')
                    ->listCheck(true);

                $childBar->archive('status.archive')->listCheck(true);

                $childBar->checkin('status.checkin')->listCheck(true);

                if ($this->state->get('filter.published') != ScholarshipsComponent::CONDITION_TRASHED)
                {
                    $childBar->trash('status.trash')->listCheck(true);
                }
            }

            // Add a batch button
            if ($user->authorise('core.create', 'com_scholarships')
                && $user->authorise('core.edit', 'com_scholarships')
                && $user->authorise('core.execute.transition', 'com_scholarships'))
            {
                $childBar->popupButton('batch')
                    ->text('JTOOLBAR_BATCH')
                    ->selector('collapseModal')
                    ->listCheck(true);
            }
        }

        if (!$this->isEmptyState && $this->state->get('filter.published') == ScholarshipsComponent::CONDITION_TRASHED && $canDo->get('core.delete'))
        {
            $toolbar->delete('status.delete')
                ->text('JTOOLBAR_EMPTY_TRASH')
                ->message('JGLOBAL_CONFIRM_DELETE')
                ->listCheck(true);
        }

        if ($user->authorise('core.admin', 'com_scholarships') || $user->authorise('core.options', 'com_scholarships'))
        {
            $toolbar->preferences('com_scholarships');
        }

        $toolbar->help('ScholarshipsStatus');
    }
}