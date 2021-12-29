<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Administrator\Model;
\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

class ScholarshipDepartmentsModel extends ListModel
{
    private string $componentName = 'com_scholarships';
    private string $tableName = '';
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->tableName = $this->getTable()->getTableName();
    }

    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select([
            $db->quoteName('id'),
            $db->quoteName('scholarship_department_name', 'name'),
            $db->quoteName('state')
        ])
            -> from($db->quoteName($this->tableName));
        return $query;
    }

    /**
     * Method to get all transitions at once for all articles
     *
     * @return  array|boolean
     *
     * @since   4.0.0
     */
    public function getTransitions(): bool|array
    {
        // Get a storage key.
        $store = $this->getStoreId('getTransitions');

        // Try to load the data from internal storage.
        if (isset($this->cache[$store]))
        {
            return $this->cache[$store];
        }

        $db   = $this->getDbo();
        $user = Factory::getUser();

        $items = $this->getItems();

        if ($items === false)
        {
            return false;
        }

        $stage_ids = ArrayHelper::getColumn($items, 'stage_id');
        $stage_ids = ArrayHelper::toInteger($stage_ids);
        $stage_ids = array_values(array_unique(array_filter($stage_ids)));

        $workflow_ids = ArrayHelper::getColumn($items, 'workflow_id');
        $workflow_ids = ArrayHelper::toInteger($workflow_ids);
        $workflow_ids = array_values(array_unique(array_filter($workflow_ids)));

        $this->cache[$store] = array();

        try
        {
            if (count($stage_ids) || count($workflow_ids))
            {
                Factory::getLanguage()->load('com_workflow', JPATH_ADMINISTRATOR);

                $query = $db->getQuery(true);

                $query	->select(
                    [
                        $db->quoteName('t.id', 'value'),
                        $db->quoteName('t.title', 'text'),
                        $db->quoteName('t.from_stage_id'),
                        $db->quoteName('t.to_stage_id'),
                        $db->quoteName('s.id', 'stage_id'),
                        $db->quoteName('s.title', 'stage_title'),
                        $db->quoteName('t.workflow_id'),
                    ]
                )
                    ->from($db->quoteName('#__workflow_transitions', 't'))
                    ->innerJoin(
                        $db->quoteName('#__workflow_stages', 's'),
                        $db->quoteName('t.to_stage_id') . ' = ' . $db->quoteName('s.id')
                    )
                    ->where(
                        [
                            $db->quoteName('t.published') . ' = 1',
                            $db->quoteName('s.published') . ' = 1',
                        ]
                    )
                    ->order($db->quoteName('t.ordering'));

                $where = [];

                if (count($stage_ids))
                {
                    $where[] = $db->quoteName('t.from_stage_id') . ' IN (' . implode(',', $query->bindArray($stage_ids)) . ')';
                }

                if (count($workflow_ids))
                {
                    $where[] = '(' . $db->quoteName('t.from_stage_id') . ' = -1 AND ' . $db->quoteName('t.workflow_id') . ' IN (' . implode(',', $query->bindArray($workflow_ids)) . '))';
                }

                $query->where('((' . implode(') OR (', $where) . '))');

                $transitions = $db->setQuery($query)->loadAssocList();

                foreach ($transitions as $key => $transition)
                {
                    if (!$user->authorise('core.execute.transition', $this->componentName.'.transition.' . (int) $transition['value']))
                    {
                        unset($transitions[$key]);
                    }

                    $transitions[$key]['text'] = Text::_($transition['text']);
                }

                $this->cache[$store] = $transitions;
            }
        }
        catch (\RuntimeException $e)
        {
            $this->setError($e->getMessage());

            return false;
        }

        return $this->cache[$store];
    }

    /**
     * Method to get a list of articles.
     * Overridden to add item type alias.
     *
     * @return  mixed  An array of data items on success, false on failure.
     *
     * @throws \Exception
     * @since   4.0.0
     */
    public function getItems(): mixed
    {
        $items = parent::getItems();

        foreach ($items as $item)
        {
            $item->typeAlias = $this->getTable()->typeAlias;;

            if (isset($item->metadata))
            {
                $registry = new Registry($item->metadata);
                $item->metadata = $registry->toArray();
            }
        }
        return $items;
    }
}