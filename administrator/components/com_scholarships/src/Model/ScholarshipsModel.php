<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Administrator\Model;
\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\ListModel;

/**
 * @since __BUMP_VERSION__
 */
class ScholarshipsModel extends ListModel
{
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select([
            $db->quoteName('a.id', 'id'),
            $db->quoteName('scholarship_year', 'year'),
            $db->quoteName('scholarship_recipient', 'recipient'),
            $db->quoteName('scholarship_college_name', 'college'),
            $db->quoteName('scholarship_department_name', 'department'),
            $db->quoteName('scholarship_status_option', 'status'),
        ])
            ->from($db->quoteName('#__scholarships', 'a'))
            ->join('LEFT', $db->quoteName('#__scholarship_status', 'b'), $db->quoteName('scholarship_fk_scholarship_status').' = '.$db->quoteName('b.id'))
            ->join('LEFT', $db->quoteName('#__scholarship_colleges', 'c'), $db->quoteName('scholarship_fk_scholarship_college').' = '.$db->quoteName('c.id'))
            ->join('LEFT', $db->quoteName('#__scholarship_departments', 'd'), $db->quoteName('scholarship_fk_scholarship_department').' = '.$db->quoteName('d.id'))
            ->join('LEFT', $db->quoteName('#__categories', 'e'), $db->quoteName('e.id').' =  '.$db->quoteName('a.catid'));
        return $query;
    }
}