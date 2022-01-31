<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2022 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Site\View\Scholarships;
\defined('_JEXEC') or die;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

class HtmlView extends BaseHtmlView
{
    protected $itemsObj;
    protected $items;
    protected $colHeadings;
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

    protected $excludeColumns = array(
        'id',
        'state',
        'version',
        'ordering',
        'created',
        'created_by',
        'created_by_alias',
        'modified',
        'language',
        'catid',
        'alias',
        'topic',
        'employment',
        'scholarship_abstract_title',
        'typeAlias',
        'color'
    );

    public function display($tpl = null): void
    {
        $this->itemsObj = $this->get('Items');
        $this->items = $this->itemsObj['items'];
        $this->colHeadings = $this->itemsObj['colHeadings'];
        $this->pagination = $this->get('Pagination');
        $this->state         = $this->get('State');
        $this->filterForm    = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');
        parent::display($tpl);
    }
}