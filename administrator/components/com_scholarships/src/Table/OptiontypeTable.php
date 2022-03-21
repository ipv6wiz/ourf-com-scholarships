<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */
namespace OURF\Component\Scholarships\Administrator\Table;
use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;

\defined('_JEXEC') or die;

class OptiontypeTable extends Table
{
    public function __construct(DatabaseDriver $db)
    {
        $table = '#__scholarship_option_types';
        $key = 'id';
        $this->typeAlias = 'com_scholarships.option_types';

        parent::__construct($table, $key, $db);
        $this->setColumnAlias('published', 'state');
    }

    public function generateAlias(): string
    {
        if (empty($this->alias)) {
            $this->alias = $this->option_type_name;
        }
        $this->alias = ApplicationHelper::stringURLSafe($this->alias, $this->language);
        if (trim(str_replace('-', '', $this->alias)) == '') {
            $this->alias = Factory::getDate()->format('Y-m-d-H-i-s');
        }
        return $this->alias;
    }
}