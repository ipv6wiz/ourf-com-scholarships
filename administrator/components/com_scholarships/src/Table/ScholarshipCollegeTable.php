<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Administrator\Table;
\defined('_JEXEC') or die;

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;

class ScholarshipCollegeTable extends Table
{

    public function __construct(DatabaseDriver $db)
    {
        $table = '#__scholarship_colleges';
        $key = 'id';
        $this->typeAlias = 'com_scholarships.scholarship_college';

        parent::__construct($table, $key, $db);
    }

    public function generateAlias(): string
    {
        if (empty($this->alias)) {
            $this->alias = $this->name;
        }
        $this->alias = ApplicationHelper::stringURLSafe($this->alias, $this->language);
        if (trim(str_replace('-', '', $this->alias)) == '') {
            $this->alias = Factory::getDate()->format('Y-m-d-H-i-s');
        }
        return $this->alias;
    }
}