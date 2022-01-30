<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace OURF\Component\Scholarships\Site\Service;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Categories\CategoryFactoryInterface;
use Joomla\CMS\Component\Router\RouterBase;
use Joomla\CMS\Menu\AbstractMenu;
use Joomla\Database\DatabaseInterface;

class Router extends RouterBase {
    public function __construct(SiteApplication $app, AbstractMenu $menu)
    {
        parent::__construct($app, $menu);
    }

    public function build(&$query) {
        $segments = array();
        if (empty($query['Itemid']))
        {
            $menuItem = $this->menu->getActive();
        }
        else
        {
            $menuItem = $this->menu->getItem($query['Itemid']);
        }

        $mView = empty($menuItem->query['view']) ? null : $menuItem->query['view'];
        $mId   = empty($menuItem->query['id']) ? null : $menuItem->query['id'];
        return $segments;
    }

    public function parse(&$segments) {
        $vars = array();
        return $vars;
    }
}