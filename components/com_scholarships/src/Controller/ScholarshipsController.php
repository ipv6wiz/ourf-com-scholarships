<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */


namespace OURF\Component\Scholarships\Site\Controller;
\defined('_JEXEC') or die;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;

class ScholarshipsController extends AdminController
{
    protected $default_view = 'scholarships';
    public function __construct($config = [], MVCFactoryInterface $factory = null, $app = null, $input = null)
    {
        parent::__construct($config, $factory, $app, $input);
    }

    public function getModel($name = 'Scholarships', $prefix = 'Site', $config = array('ignore_request' => true)): \Joomla\CMS\MVC\Model\BaseDatabaseModel|bool
    {
        return parent::getModel($name, $prefix, $config);
    }
}