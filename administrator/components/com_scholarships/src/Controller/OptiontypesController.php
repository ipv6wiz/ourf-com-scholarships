<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2022 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */
namespace OURF\Component\Scholarships\Administrator\Controller;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\Input\Input;

\defined('_JEXEC') or die;

class OptiontypesController extends AdminController
{
    public function __construct($config = array(), MVCFactoryInterface $factory = null, $app = null,  $input = null)
    {
        parent::__construct($config, $factory, $app, $input);
    }

    public function getModel($name= 'Optiontype', $prefix='Administrator',  $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, $config);
    }
}