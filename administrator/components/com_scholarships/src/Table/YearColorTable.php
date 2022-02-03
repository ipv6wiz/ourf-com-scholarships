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
use Joomla\Database\DatabaseDriver;
use Joomla\CMS\Table\Table;

\defined('_JEXEC') or die;
class YearColorTable extends Table
{
    public function __construct(DatabaseDriver $db)
    {
        $table = '#__scholarship_year_colors';
        $key = 'id';
        $this->typeAlias = 'com_scholarships.year_color';
        parent::__construct($table, $key, $db);
    }

    public function generateAlias(): string
    {
        if (empty($this->alias)) {
            $this->alias = $this->year;
        }
        if (trim(str_replace('-', '', $this->alias)) == '') {
            $this->alias = Factory::getDate()->format('Y-m-d-H-i-s');
        }
        return $this->alias;
    }
}