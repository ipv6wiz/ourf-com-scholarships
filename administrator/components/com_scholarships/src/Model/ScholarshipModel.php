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
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormFactoryInterface;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\MVC\Model\WorkflowBehaviorTrait;
use Joomla\CMS\MVC\Model\WorkflowModelInterface;

/**
 * Item Model for a Scholarship.
 *
 * @since  __BUMP_VERSION__
 */
class ScholarshipModel extends AdminModel implements WorkflowModelInterface
{
    use WorkflowBehaviorTrait;
    /**
     * The type alias for this content type.
     *
     * @var    string
     * @since  __BUMP_VERSION__
     */
    public $typeAlias = 'com_scholarships.scholarship';

    public function __construct($config = array(), MVCFactoryInterface $factory = null, FormFactoryInterface $formFactory = null)
    {
        parent::__construct($config, $factory, $formFactory);
        $this->setUpWorkflow('com_scholarships.scholarship');
    }

    /**
     * Method to test whether a record can have its state edited.
     *
     * @param   object  $record  A record object.
     *
     * @return  boolean  True if allowed to change the state of the record. Defaults to the permission set in the component.
     *
     * @since   1.6
     */
    protected function canEditState($record)
    {
        $user = Factory::getUser();

        // Check for existing article.
        if (!empty($record->id))
        {
            return $user->authorise('core.edit.state', 'com_scholarships.scholarship.' . (int) $record->id);
        }

        // New article, so check against the category.
        if (!empty($record->catid))
        {
            return $user->authorise('core.edit.state', 'com_scholarships.category.' . (int) $record->catid);
        }

        // Default to component settings if neither article nor category known.
        return parent::canEditState($record);
    }

    /**
     * Method to get the row form.
     *
     * @param array $data Data for the form.
     * @param boolean $loadData True if the form is to load its own data (default case), false if not.
     *
     * @return  \JForm|boolean  A \JForm object on success, false on failure
     *
     * @throws \Exception
     * @since   __BUMP_VERSION__
     */
    public function getForm($data = [], $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm($this->typeAlias, 'scholarship', ['control' => 'jform', 'load_data' => $loadData]);
        if (empty($form)) {
            return false;
        }
        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed  The data for the form.
     *
     * @throws \Exception
     * @since   __BUMP_VERSION__
     */
    protected function loadFormData()
    {
        $app = Factory::getApplication();
        $data = $this->getItem();
        $this->preprocessData($this->typeAlias, $data);
        return $data;
    }
    /**
     * Prepare and sanitise the table prior to saving.
     *
     * @param   \Joomla\CMS\Table\Table  $table  The Table object
     *
     * @return  void
     *
     * @since   __BUMP_VERSION__
     */
    protected function prepareTable($table)
    {
        $table->generateAlias();
    }

    /**
     * Method to change the published state of one or more records.
     *
     * @param   array    &$pks   A list of the primary keys to change.
     * @param   integer  $value  The value of the published state.
     *
     * @return  boolean  True on success.
     *
     * @since   4.0.0
     */
    public function publish(&$pks, $value = 1)
    {
        $this->workflowBeforeStageChange();

        return parent::publish($pks, $value);
    }

    public function save($data)
    {
        $this->workflowBeforeSave();
        $data['scholarship_fk_color'] = $this->getColor($data['scholarship_year']);
        if(parent::save($data)) {
            $this->workflowAfterSave($data);
            return true;
        }
        return false;
    }

    private function getColor($year) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            -> select($db->quoteName('fk_colors', 'color'))
            ->from($db->quoteName('#__scholarship_year_colors'))
            ->where($db->quoteName('year').' = '.$db->quote($year))
            ->setLimit(1);
        $db->setQuery($query);
        $color = $db->loadAssoc()['color'];

        if(!$color) {
            $color = $this->getNextColor($db, $year);
        }
        return $color;
    }

    private function getNextColor(&$db, $year) {
        $query = $db->getQuery(true)
            ->select ('count(*) as color_count')
            ->from ($db->quoteName('#__scholarship_colors'));
        $db->setQuery($query);
        $color_count = $db->loadAssoc()['color_count'];
        $query = $db->getQuery(true)
            -> select($db->quoteName('fk_colors', 'last_color'))
            ->from($db->quoteName('#__scholarship_year_colors'))
            ->order($db->quoteName('id'). "DESC")
            ->setLimit(1);
        $db->setQuery($query);
        $last_color = $db->loadAssoc()['last_color'];
        $color = (($last_color + 1) % $color_count !== 0 ) ? $last_color + 1 : 1;
        $this->addNewYearColor($db, $year, $color);
        return $color;
    }

    private function addNewYearColor(&$db, $year, $color) {
        $table = $this->getTable('YearColor');
        $data = ['fk_colors'=>$color, 'year'=>$year];
        if (!$table->bind($data))
        {
            $this->setError($table->getError());
            return false;
        }
        // Prepare the row for saving
        $this->prepareTable($table);
        // Store the data.
        if (!$table->store())
        {
            $this->setError($table->getError());
            return false;
        }
        // Clean the cache.
        $this->cleanCache();
    }
}