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
        'modified',
        'language',
        'catid',
        'alias',
        'typeAlias',
        'scholarship_abstract_title',
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