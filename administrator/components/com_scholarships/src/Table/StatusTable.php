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
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;

class StatusTable extends Table
{

    public function __construct(DatabaseDriver $db)
    {
        $table = '#__scholarship_status';
        $key = 'id';
        $this->typeAlias = 'com_scholarships.status';

        parent::__construct($table, $key, $db);
        $this->setColumnAlias('published', 'state');
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