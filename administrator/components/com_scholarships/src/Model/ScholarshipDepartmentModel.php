<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Administrator\Model;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormFactoryInterface;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\MVC\Model\WorkflowBehaviorTrait;
use Joomla\CMS\MVC\Model\WorkflowModelInterface;

\defined('_JEXEC') or die;

class ScholarshipDepartmentModel extends AdminModel implements WorkflowModelInterface
{
    use WorkflowBehaviorTrait;

    public $typeAlias = '';
    private $componentName = '';
    private $formName = '';

    public function __construct($config = array(), MVCFactoryInterface $factory = null, FormFactoryInterface $formFactory = null)
    {
        parent::__construct($config, $factory, $formFactory);
        $this->typeAlias = $this->getTable()->typeAlias;
        $this->componentName = preg_split('.', $this->typeAlias)[0];
        $this->formName = preg_split('.', $this->typeAlias)[1];
        $this->setUpWorkflow($this->typeAlias);
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
            return $user->authorise('core.edit.state', $this->typeAlias.'.' . (int) $record->id);
        }

        // New article, so check against the category.
        if (!empty($record->catid))
        {
            return $user->authorise('core.edit.state', $this->componentName.'.category.' . (int) $record->catid);
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
        $form = $this->loadForm($this->typeAlias, $this->formName, ['control' => 'jform', 'load_data' => $loadData]);
        if (empty($form)) {
            return false;
        }
        return $form;
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
        if(parent::save($data)) {
            $this->workflowAfterSave($data);
            return true;
        }
        return false;
    }
}