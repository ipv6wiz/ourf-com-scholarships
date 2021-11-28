<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

\defined('_JEXEC') or die;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\Service\Provider\CategoryFactory;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\HTML\Registry;
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
        $container->registerServiceProvider(new CategoryFactory('\\OURF\\Component\\Scholarships'));
        $container->registerServiceProvider(new MVCFactory('\\OURF\\Component\\Scholarships'));
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\OURF\\Component\\Scholarships'));
        $container->set(
            ComponentInterface::class,
            function (Container $container) {
                $component = new ScholarshipsComponent($container->get(ComponentDispatcherFactoryInterface::class));
                $component->setRegistry($container->get(Registry::class));
                return $component;
            }
        );
    }
};