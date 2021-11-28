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
use Joomla\CMS\MVC\Controller\BaseController;
/**
 * Scholarships master display controller.
 *
 * @since  1.0.0
 */
class DisplayController extends BaseController
{
    /**
     * The default view.
     *
     * @var    string
     * @since  1.0.0
     */
    protected $default_view = 'scholarships';
    /**
     * Method to display a view.
     *
     * @param   boolean  $cachable   If true, the view output will be cached
     * @param   array    $urlparams  An array of safe URL parameters and their variable types, for valid values see {@link \JFilterInput::clean()}.
     *
     * @return  BaseController|bool  This object to support chaining.
     *
     * @since   1.0.0
     *
     * @throws  \Exception
     */
    public function display($cachable = false, $urlparams = [])
    {
        return parent::display();
    }
}