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
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

/**
 * @since __BUMP_VERSION__
 */
class ScholarshipsModel extends ListModel
{
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select([
            $db->quoteName('a.id', 'id'),
            $db->quoteName('scholarship_year', 'year'),
            $db->quoteName('scholarship_recipient', 'recipient'),
            $db->quoteName('scholarship_college_name', 'college'),
            $db->quoteName('scholarship_department_name', 'department'),
            $db->quoteName('scholarship_status_option', 'status'),
            $db->quoteName('a.state', 'state'),
        ])
            ->from($db->quoteName('#__scholarships', 'a'))
            ->join('LEFT', $db->quoteName('#__scholarship_status', 'b'), $db->quoteName('scholarship_fk_scholarship_status').' = '.$db->quoteName('b.id'))
            ->join('LEFT', $db->quoteName('#__scholarship_colleges', 'c'), $db->quoteName('scholarship_fk_scholarship_college').' = '.$db->quoteName('c.id'))
            ->join('LEFT', $db->quoteName('#__scholarship_departments', 'd'), $db->quoteName('scholarship_fk_scholarship_department').' = '.$db->quoteName('d.id'))
            ->join('LEFT', $db->quoteName('#__categories', 'e'), $db->quoteName('e.id').' =  '.$db->quoteName('a.catid'));
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
                    if (!$user->authorise('core.execute.transition', 'com_scholarships.transition.' . (int) $transition['value']))
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
     * @since   4.0.0
     */
    public function getItems(): mixed
    {
        $items = parent::getItems();

        foreach ($items as $item)
        {
            $item->typeAlias = 'com_scholarships.scholarship';

            if (isset($item->metadata))
            {
                $registry = new Registry($item->metadata);
                $item->metadata = $registry->toArray();
            }
        }

        return $items;
    }
}