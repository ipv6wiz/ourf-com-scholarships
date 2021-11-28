<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Administrator\Extension;
defined('JPATH_PLATFORM') or die;
use Joomla\CMS\Categories\CategoryServiceInterface;
use Joomla\CMS\Categories\CategoryServiceTrait;
use Joomla\CMS\Extension\BootableExtensionInterface;
use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\HTML\HTMLRegistryAwareTrait;
use OURF\Component\Scholarships\Administrator\Service\HTML\AdministratorService;
use Psr\Container\ContainerInterface;
/**
 * Component class for com_scholarships
 *
 * @since  1.0.0
 */
class ScholarshipsComponent extends MVCComponent implements BootableExtensionInterface, CategoryServiceInterface
{
    use CategoryServiceTrait;
    use HTMLRegistryAwareTrait;
    /**
     * Booting the extension. This is the function to set up the environment of the extension like
     * registering new class loaders, etc.
     *
     * If required, some initial set up can be done from services of the container, eg.
     * registering HTML services.
     *
     * @param   ContainerInterface  $container  The container
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function boot(ContainerInterface $container)
    {
        $this->getRegistry()->register('scholarshipsadministrator', new AdministratorService);
    }
}