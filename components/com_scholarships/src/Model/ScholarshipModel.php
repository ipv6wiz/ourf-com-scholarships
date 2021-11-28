<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Site\Model;
\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
/**
 * Scholarship model for the Joomla Scholarships component.
 *
 * @since  __BUMP_VERSION__
 */
class ScholarshipModel extends BaseDatabaseModel
{
    /**
     * @var string message
     * @since sometime
     */
    protected $message;
    
    /**
     * Get the message
     *
     * @return  string  The message to be displayed to the user
     * @since sometime
     */
    public function getMsg()
    {
        $app = Factory::getApplication();
        $this->message = $app->input->get('show_text', "Hi");
        return $this->message;
    }
}