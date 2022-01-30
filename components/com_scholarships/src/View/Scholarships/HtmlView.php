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
        parent::display($tpl);
    }
}