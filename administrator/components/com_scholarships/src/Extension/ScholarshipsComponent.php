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
use Joomla\CMS\Component\Router\RouterServiceInterface;
use Joomla\CMS\Component\Router\RouterServiceTrait;
use Joomla\CMS\Extension\BootableExtensionInterface;
use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLRegistryAwareTrait;
use Joomla\CMS\Workflow\WorkflowServiceInterface;
use Joomla\CMS\Workflow\WorkflowServiceTrait;
use OURF\Component\Scholarships\Administrator\Helper\ScholarshipHelper;
use OURF\Component\Scholarships\Administrator\Service\HTML\AdministratorService;
use Psr\Container\ContainerInterface;
/**
 * Component class for com_scholarships
 *
 * @since  1.0.0
 */
class ScholarshipsComponent extends MVCComponent implements
    BootableExtensionInterface, CategoryServiceInterface, WorkflowServiceInterface, RouterServiceInterface
{
    use CategoryServiceTrait;
    use RouterServiceTrait;
    use HTMLRegistryAwareTrait;
    use WorkflowServiceTrait;

    /**
     * The trashed condition
     *
     * @since   4.0.0
     */
    const CONDITION_NAMES = [
        self::CONDITION_PUBLISHED   => 'JPUBLISHED',
        self::CONDITION_UNPUBLISHED => 'JUNPUBLISHED',
        self::CONDITION_ARCHIVED    => 'JARCHIVED',
        self::CONDITION_TRASHED     => 'JTRASHED',
    ];

    /**
     * The archived condition
     *
     * @since   4.0.0
     */
    const CONDITION_ARCHIVED = 2;

    /**
     * The published condition
     *
     * @since   4.0.0
     */
    const CONDITION_PUBLISHED = 1;

    /**
     * The unpublished condition
     *
     * @since   4.0.0
     */
    const CONDITION_UNPUBLISHED = 0;

    /**
     * The trashed condition
     *
     * @since   4.0.0
     */
    const CONDITION_TRASHED = -2;
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

    /**
     * Returns a table name for the state association
     *
     * @param   string  $section  An optional section to separate different areas in the component
     *
     * @return  string
     *
     * @since   4.0.0
     */
    public function getWorkflowTableBySection(?string $section = null): string
    {
        return '#__content';
    }

    /**
     * Returns the workflow context based on the given category section
     *
     * @param   string  $section  The section
     *
     * @return  string|null
     *
     * @since   4.0.0
     */
    public function getCategoryWorkflowContext(?string $section = null): string
    {
        $context = $this->getWorkflowContexts();

        return array_key_first($context);
    }

    /**
     * Returns valid contexts
     *
     * @return  array
     *
     * @since   4.0.0
     */
    public function getWorkflowContexts(): array
    {
        Factory::getLanguage()->load('com_scholarships', JPATH_ADMINISTRATOR);

        $contexts = array(
            'com_scholarships.scholarship'    => Text::_('COM_SCHOLARSHIP')
        );

        return $contexts;
    }

    /**
     * Method to filter transitions by given id of state.
     *
     * @param   array  $transitions  The Transitions to filter
     * @param   int    $pk           Id of the state
     *
     * @return  array
     *
     * @since  4.0.0
     */
    public function filterTransitions(array $transitions, int $pk): array
    {
        return ScholarshipHelper::filterTransitions($transitions, $pk);
    }
}