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
use Joomla\CMS\MVC\Model\AdminModel;
/**
 * Item Model for a Scholarship.
 *
 * @since  __BUMP_VERSION__
 */
class ScholarshipModel extends AdminModel
{
    /**
     * The type alias for this content type.
     *
     * @var    string
     * @since  __BUMP_VERSION__
     */
    public $typeAlias = 'com_scholarships.scholarship';
    /**
     * Method to get the row form.
     *
     * @param   array    $data      Data for the form.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     *
     * @return  \JForm|boolean  A \JForm object on success, false on failure
     *
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
}