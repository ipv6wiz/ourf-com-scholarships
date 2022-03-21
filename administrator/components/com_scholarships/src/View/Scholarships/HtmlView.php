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

require_once (JPATH_ADMINISTRATOR.'/components/com_plotalot/helpers/plotalot.php');

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
 * View class for a list of Scholarships.
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

    public $charts = [];
    private $plots = [];
    protected $chartCols = 2;
    protected $chartRows = 0;

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
        $this->addCharts();
        parent::display($tpl);
    }

    protected function addCharts()
    {
        $plotalot = new \Plotalot();
        $this->yearPieChart();
        $this->yearLineChart();
        $this->yearComboChart();
        $this->schoolPieChart();
        foreach ($this->plots as $plot) {
            $this->charts[$plot->id] = $plotalot->drawChart($plot);
        }
        $this->chartRows = floor(sizeof($this->charts)/$this->chartCols) + (sizeof($this->charts) % $this->chartCols === 0 ? 0 : 1);
    }

    private function yearPieChart()
    {
        $plot_info = new \stdClass();
        $plot_info->id = sizeof($this->plots) + 1;
        $plot_info->chart_title = 'By Year';
        $plot_info->chart_type = CHART_TYPE_PIE_3D_V;
//        $plot_info->chart_option = PIE_TEXT_LABEL;
        $plot_info->legend_type = LEGEND_LABELLED;
        $plot_info->x_size = 600;
        $plot_info->y_size = 400;
        $plot_info->num_plots = 1;
// construct the plot array
        $plot_info->plot_array = array();
        $plot_info->plot_array[0]['enable'] = 1;
        $plot_info->plot_array[0]['colour'] = '7C78FF';
        $plot_info->plot_array[0]['style'] = PIE_MULTI_COLOUR;
        $query = "select scholarship_year, count(*) as qty FROM #__scholarships where state=1 group by scholarship_year";
        $plot_info->plot_array[0]['query'] = $query;
        array_push($this->plots, $plot_info);
    }

    private function yearLineChart()
    {
        $plot_info = new \stdClass();
        $plot_info->id = sizeof($this->plots) + 1;
        $plot_info->chart_title = 'By Year';
        $plot_info->chart_type = CHART_TYPE_LINE;
//        $plot_info->chart_option = PIE_TEXT_LABEL;
//        $plot_info->legend_type = LEGEND_LABELLED;
        $plot_info->x_size = 600;
        $plot_info->y_size = 400;
        $plot_info->num_plots = 1;
// construct the plot array
        $plot_info->plot_array = array();
        $plot_info->plot_array[0]['enable'] = 1;
        $plot_info->plot_array[0]['colour'] = '00FF00';
        $plot_info->plot_array[0]['style'] = LINE_THICK_SOLID;
        $query = "select scholarship_year, count(*) as qty FROM #__scholarships where state=1 group by scholarship_year";
        $plot_info->plot_array[0]['query'] = $query;
        array_push($this->plots, $plot_info);
    }

    private function yearComboChart()
    {
        $query = "select UNIX_TIMESTAMP(STR_TO_DATE(concat(scholarship_year, '-01-01'), '%Y-%m-%d')) as Year, count(*) as qty FROM #__scholarships where state=1 group by scholarship_year";
        $plot_info = new \stdClass();
        $plot_info->id = sizeof($this->plots) + 1;
        $plot_info->chart_title = 'By Year';
        $plot_info->chart_type = CHART_TYPE_COMBO_STACK;
//        $plot_info->chart_option = PIE_TEXT_LABEL;
//        $plot_info->legend_type = LEGEND_LABELLED;
        $plot_info->x_format = 299;
        $plot_info->custom_x_format="yyyy";
        $plot_info->x_size = 600;
        $plot_info->y_size = 400;
        $plot_info->num_plots = 2;
// construct the plot array
        $plot_info->plot_array = array();
        $plot_info->plot_array[0]['enable'] = 1;
        $plot_info->plot_array[0]['colour'] = '00FF00';
        $plot_info->plot_array[0]['style'] = 0;
//        $plot_info->plot_array[0]['type'] = 'bars';
        $plot_info->plot_array[0]['query'] = $query;

        $plot_info->plot_array[1]['enable'] = 1;
        $plot_info->plot_array[1]['colour'] = '00FF00';
        $plot_info->plot_array[1]['style'] = 60;
//        $plot_info->plot_array[1]['type'] = 'line';
        $plot_info->plot_array[1]['query'] = $query;

        array_push($this->plots, $plot_info);
    }

    private function schoolPieChart()
    {
        $plot_info = new \stdClass();
        $plot_info->id = sizeof($this->plots) + 1;
        $plot_info->chart_title = 'By School';
        $plot_info->chart_type = CHART_TYPE_PIE_3D_V;
//        $plot_info->chart_option = PIE_TEXT_LABEL;
        $plot_info->legend_type = LEGEND_LABELLED;
        $plot_info->x_size = 600;
        $plot_info->y_size = 400;
        $plot_info->num_plots = 1;
// construct the plot array
        $plot_info->plot_array = array();
        $plot_info->plot_array[0]['enable'] = 1;
        $plot_info->plot_array[0]['colour'] = '7C78FF';
        $plot_info->plot_array[0]['style'] = PIE_MULTI_COLOUR;
        $query = "select scholarship_college_name as College, count(*) as qty from #__scholarships a left join #__scholarship_colleges b on b.id = a.scholarship_fk_scholarship_college where a.state=1 group by College order by qty DESC;";
        $plot_info->plot_array[0]['query'] = $query;
        array_push($this->plots, $plot_info);
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

        ToolbarHelper::title(Text::_('COM_SCHOLARSHIPS_MANAGER_SCHOLARSHIPS'), 'address scholarship');

        if ($canDo->get('core.create') || \count($user->getAuthorisedCategories('com_scholarships', 'core.create')) > 0)
        {
            $toolbar->addNew('scholarship.add');
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

                $cmd = "Joomla.submitbutton('scholarships.runTransition');";
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
                $childBar->publish('scholarships.publish')->listCheck(true);

                $childBar->unpublish('scholarships.unpublish')->listCheck(true);

                $childBar->standardButton('featured')
                    ->text('JFEATURE')
                    ->task('scholarships.featured')
                    ->listCheck(true);

                $childBar->standardButton('unfeatured')
                    ->text('JUNFEATURE')
                    ->task('scholarships.unfeatured')
                    ->listCheck(true);

                $childBar->archive('scholarships.archive')->listCheck(true);

                $childBar->checkin('scholarships.checkin')->listCheck(true);

                if ($this->state->get('filter.published') != ScholarshipsComponent::CONDITION_TRASHED)
                {
                    $childBar->trash('scholarships.trash')->listCheck(true);
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
            $toolbar->delete('scholarships.delete')
                ->text('JTOOLBAR_EMPTY_TRASH')
                ->message('JGLOBAL_CONFIRM_DELETE')
                ->listCheck(true);
        }

        if ($user->authorise('core.admin', 'com_scholarships') || $user->authorise('core.optiontypes', 'com_scholarships'))
        {
            $toolbar->preferences('com_scholarships');
        }

        $toolbar->help('Scholarships');
    }
}