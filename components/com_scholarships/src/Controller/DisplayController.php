<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Site\Controller;
\defined('_JEXEC') or die;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
/**
 * Scholarships Component Controller
 *
 * @since  __BUMP_VERSION__
 */
class DisplayController extends BaseController
{
    /**
     * Constructor.
     *
     * @param array $config An optional associative array of configuration settings.
     * Recognized key values include 'name', 'default_task', 'model_path', and
     * 'view_path' (this list is not meant to be comprehensive).
     * @param MVCFactoryInterface|null $factory The factory.
     * @param null $app The JApplication for the dispatcher
     * @param null $input Input
     *
     * @since   __BUMP_VERSION__
     */
    public function __construct($config = [], MVCFactoryInterface $factory = null, $app = null, $input = null)
    {
        parent::__construct($config, $factory, $app, $input);
    }

    public function getModel($name = 'Scholarships', $prefix = 'Site', $config = array('ignore_request' => true)): \Joomla\CMS\MVC\Model\BaseDatabaseModel|bool
    {
        return parent::getModel($name, $prefix, $config);
    }

    /**
     * Method to display a view.
     *
     * @param boolean $cachable If true, the view output will be cached
     * @param array $urlparams An array of safe URL parameters and their variable types, for valid values see {@link \JFilterInput::clean()}.
     *
     * @return  static  This object to support chaining.
     *
     * @throws \Exception
     * @since   __BUMP_VERSION__
     */
    public function display($cachable = false, $urlparams = [])
    {
        parent::display($cachable);
        return $this;
    }
}