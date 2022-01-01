<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Administrator\Controller;
\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;

class StatusesController extends AdminController
{
    public function __construct($config = array(), MVCFactoryInterface $factory = null, $app = null, $input = null)
    {
        parent::__construct($config, $factory, $app, $input);
    }

    /**
     * Proxy for getModel.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  The array of possible config values. Optional.
     *
     * @return  \Joomla\CMS\MVC\Model\BaseDatabaseModel
     *
     * @since   1.6
     */
    public function getModel($name = 'ScholarshipStatus', $prefix = 'Administrator', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }
}