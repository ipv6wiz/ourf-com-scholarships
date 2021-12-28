<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Association\AssociationExtensionInterface;
use Joomla\CMS\Categories\CategoryFactoryInterface;

use Joomla\CMS\Component\Router\RouterFactoryInterface;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\Service\Provider\CategoryFactory;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Extension\Service\Provider\RouterFactory;
use Joomla\CMS\HTML\Registry;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\Component\Associations\Administrator\Helper\AssociationsHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use OURF\Component\Scholarships\Administrator\Extension\ScholarshipsComponent;
/**
 * The foos service provider.
 * https://github.com/joomla/joomla-cms/pull/20217
 *
 * @since  1.0.0
 */
return new class implements ServiceProviderInterface
{
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function register(Container $container)
    {
        $container->set(AssociationExtensionInterface::class, new AssociationsHelper);
        $container->registerServiceProvider(new CategoryFactory('\\OURF\\Component\\Scholarships'));
        $container->registerServiceProvider(new MVCFactory('\\OURF\\Component\\Scholarships'));
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\OURF\\Component\\Scholarships'));
        $container->registerServiceProvider(new RouterFactory('\\OURF\\Component\\Scholarships'));
        $container->set(
            ComponentInterface::class,
            function (Container $container) {
                $component = new ScholarshipsComponent($container->get(ComponentDispatcherFactoryInterface::class));
                $component->setRegistry($container->get(Registry::class));
                $component->setMVCFactory($container->get(MVCFactoryInterface::class));
                $component->setCategoryFactory($container->get(CategoryFactoryInterface::class));
                $component->setAssociationExtension($container->get(AssociationExtensionInterface::class));
                $component->setRouterFactory($container->get(RouterFactoryInterface::class));
                return $component;
            }
        );
    }
};