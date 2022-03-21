<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2022 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Site\Model;

\defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\Database\ParameterType;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

class ScholarshipsModel extends ListModel
{
    protected array $rowColors= [
        'table-primary',
        'table-secondary',
        'table-success',
        'table-danger',
        'table-warning',
        'table-info',
    ];

    protected array $colHeadings = [
        'Year',
        'Recipient',
        'College',
        'Department',
        'Status'
    ];
    public function __construct($config = array())
    {
        $this->app = Factory::getApplication();
        if(empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'year', 'scholarship_year',
                'recipient', 'scholarship_recipient',
                'college', 'scholarship_college_name',
                'department', 'scholarship_department_name',
                'status', 'scholarship_status_option'
            );
            if (Associations::isEnabled())
            {
                $config['filter_fields'][] = 'association';
            }
        }
        parent::__construct($config);
    }

    public function getFilterForm($data = array(), $loadData = true)
    {
        $form = parent::getFilterForm($data, $loadData);
        return $form;
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param string $ordering An optional ordering field.
     * @param string $direction An optional direction (asc|desc).
     *
     * @return  void
     *
     * @throws \Exception
     * @since   1.6
     */
    protected function populateState($ordering = 'scholarship_year', $direction = 'desc')
    {
        $app = Factory::getApplication();

        $forcedLanguage = $app->input->get('forcedLanguage', '', 'cmd');

        // Adjust the context to support modal layouts.
        if ($layout = $app->input->get('layout'))
        {
            $this->context .= '.' . $layout;
        }

        // Adjust the context to support forced languages.
        if ($forcedLanguage)
        {
            $this->context .= '.' . $forcedLanguage;
        }

        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);

        $language = $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '');
        $this->setState('filter.language', $language);

        $formSubmited = $app->input->post->get('form_submited');

        // Gets the value of a user state variable and sets it in the session
        $this->getUserStateFromRequest($this->context . '.filter.scholarship_year', 'filter_scholarship_year');
        $this->getUserStateFromRequest($this->context . '.filter.scholarship_recipient', 'filter_scholarship_recipient');
        $this->getUserStateFromRequest($this->context . '.filter.scholarship_college_name', 'filter_scholarship_college_name');
        $this->getUserStateFromRequest($this->context . '.filter.scholarship_department_name', 'filter_scholarship_department_name', '');

        if ($formSubmited)
        {
            $year = $app->input->post->get('scholarship_year');
            $this->setState('filter.scholarship_year', $year);

            $recipientName = $app->input->post->get('scholarship_recipient');
            $this->setState('filter.scholarship_recipient', $recipientName);

            $collegeName = $app->input->post->get('scholarship_college_name');
            $this->setState('filter.scholarship_college_name', $collegeName);

            $departmentName = $app->input->post->get('scholarship_department_name');
            $this->setState('filter.scholarship_department_name', $departmentName);
        }

        // List state information.
        parent::populateState($ordering, $direction);

        // Force a language
        if (!empty($forcedLanguage))
        {
            $this->setState('filter.language', $forcedLanguage);
            $this->setState('filter.forcedLanguage', $forcedLanguage);
        }
    }

    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
//        $user  = Factory::getUser();
        $user = $this->app->getIdentity();
        $params = ComponentHelper::getParams('com_scholarships');

        $query->select(
            $this->getState(
                'list.select',
                [
                    $db->quoteName('a.id'),
                    $db->quoteName('a.state'),
                    $db->quoteName('a.version'),
                    $db->quoteName('a.ordering'),
                    $db->quoteName('a.created'),
                    $db->quoteName('a.created_by'),
                    $db->quoteName('a.created_by_alias'),
                    $db->quoteName('a.modified'),
                    $db->quoteName('a.language'),
                    $db->quoteName('a.catid'),
                    $db->quoteName('a.alias'),
                    $db->quoteName('scholarship_topic', 'topic'),
                    $db->quoteName('scholarship_employment', 'employment'),
                    $db->quoteName('scholarship_abstract_title')
                ]
            )
        )

            ->select([
                $db->quoteName('a.id', 'id'),
                $db->quoteName('scholarship_year', 'year'),
                $db->quoteName('scholarship_recipient', 'recipient'),
                $db->quoteName('scholarship_college_name', 'college'),
                $db->quoteName('scholarship_department_name', 'department'),
                $db->quoteName('scholarship_status_option', 'status'),
                $db->quoteName('x.class', 'color'),
                $db->quoteName('a.state', 'state'),
            ])
            ->from($db->quoteName('#__scholarships', 'a'))
            ->join('LEFT', $db->quoteName('#__scholarship_year_colors', 'y'), $db->quoteName('scholarship_fk_color').' = '.$db->quoteName('y.id'))
            ->join('LEFT', $db->quoteName('#__scholarship_colors', 'x'), $db->quoteName('y.fk_colors').' = '.$db->quoteName('x.id'))
            ->join('LEFT', $db->quoteName('#__scholarship_status', 'b'), $db->quoteName('scholarship_fk_scholarship_status').' = '.$db->quoteName('b.id'))
            ->join('LEFT', $db->quoteName('#__scholarship_colleges', 'c'), $db->quoteName('scholarship_fk_scholarship_college').' = '.$db->quoteName('c.id'))
            ->join('LEFT', $db->quoteName('#__scholarship_departments', 'd'), $db->quoteName('scholarship_fk_scholarship_department').' = '.$db->quoteName('d.id'))
            ->join('LEFT', $db->quoteName('#__languages', 'l'), $db->quoteName('l.lang_code') . ' = ' . $db->quoteName('a.language'))
            ->join('LEFT', $db->quoteName('#__users', 'ua'), $db->quoteName('ua.id') . ' = ' . $db->quoteName('a.created_by'))
            ->join('LEFT', $db->quoteName('#__categories', 'e'), $db->quoteName('e.id').' =  '.$db->quoteName('a.catid'));

        // Filter by published state
        //        $published = "1";
        $published = (string) $this->getState('filter.published');

        if ($published !== '*')
        {
            if (is_numeric($published))
            {
                $state = (int) $published;
                $query->where($db->quoteName('a.state') . ' = :state')
                    ->bind(':state', $state, ParameterType::INTEGER);
            }
        }

        // Filter by year(s)
        $year = $this->getState('filter.scholarship_year');
        if(is_string($year)) {
            $query->where($db->quoteName('scholarship_year').' = '.':year')
                ->bind(':year', $year, ParameterType::STRING);
        } elseif (is_array($year)) {
            $query->whereIn($db->quoteName('scholarship_year'), $year, ParameterType::STRING);
        }

        // Filter by Recipient
        $recipient = $this->getState('filter.scholarship_recipient');
        if(!empty($recipient)) {
            $query->where($db->quoteName('scholarship_recipient').' = '.':recipient')
                ->bind(':recipient', $recipient, ParameterType::STRING);
        }

        // Filter by College
        $college = $this->getState('filter.scholarship_college_name');
        if(!empty($college)) {
            if(is_string($college)) {
                $query->where($db->quoteName('scholarship_college_name').' = '.':college')
                    ->bind(':college', $college, ParameterType::STRING);
            } elseif (is_array($college)) {
                $query->whereIn($db->quoteName('scholarship_college_name'), $college, ParameterType::STRING);
            }
        }

        // Filter by Department
        $department = $this->getState('filter.scholarship_department_name');
        if(!empty($department)) {
            if(is_string($department)) {
                $query->where($db->quoteName('scholarship_department_name').' = '.':department')
                    ->bind(':department', $department, ParameterType::STRING);
            } elseif (is_array($department)) {
                $query->whereIn($db->quoteName('scholarship_department_name'), $department, ParameterType::STRING);
            }
        }

        // Filter by search in Recipient, College, Department.
        $search = $this->getState('filter.search');

        if (!empty($search))
        {
            if (stripos($search, 'id:') === 0)
            {
                $search = (int) substr($search, 3);
                $query->where($db->quoteName('a.id') . ' = :search')
                    ->bind(':search', $search, ParameterType::INTEGER);
            }
            elseif (stripos($search, 'recipient:') === 0)
            {
                $search = '%' . substr($search, strlen('recipient:')) . '%';
                $query->where('(' . $db->quoteName('scholarship_recipient') . ' LIKE :search1 ')
                    ->bind(':search1', $search);
            }
            elseif (stripos($search, 'college:') === 0)
            {
                $search = '%' . substr($search, strlen('college:')) . '%';
                $query->where('(' . $db->quoteName('scholarship_college_name') . ' LIKE :search1')
                    ->bind(':search1', $search);
            }
            elseif (stripos($search, 'department:') === 0)
            {
                $search = '%' . substr($search, strlen('department:')) . '%';
                $query->where('(' . $db->quoteName('scholarship_department_name') . ' LIKE :search1')
                    ->bind(':search1', $search);
            }
            else
            {
                $search = '%' . str_replace(' ', '%', trim($search)) . '%';
                $query->where(
                    '(' . $db->quoteName('scholarship_recipient') . ' LIKE :search1 OR ' . $db->quoteName('scholarship_college_name') . ' LIKE :search2'
                    . ' OR ' . $db->quoteName('scholarship_department_name') . ' LIKE :search3)'
                )
                    ->bind([':search1', ':search2', ':search3'], $search);
            }
        }

        // Add the list ordering clause.
        $orderCol  = $this->state->get('list.ordering', 'scholarship_year');
        $orderDirn = $this->state->get('list.direction', 'DESC');

        $ordering = $db->escape($orderCol) . ' ' . $db->escape($orderDirn);


        $query->order($ordering);

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
        $year = 0;
        $index = 0; // color table index
        foreach ($items as $item)
        {
            $item->typeAlias = 'com_scholarships.scholarship';

//            if($year === 0) {
//                $year = $item->scholarship_year;
//            } elseif ($year !== $item->scholarship_year) {
//                $index = $this->bumpColor($index);
//            }
//            $item->color = $this->rowColors[$index];
            if (isset($item->metadata))
            {
                $registry = new Registry($item->metadata);
                $item->metadata = $registry->toArray();
            }
        }
        $itemsObj = array();
        $itemsObj['items'] = $items;
        $itemsObj['colors'] = $this->rowColors;
        $itemsObj['colHeadings'] = $this->colHeadings;
        return $itemsObj;
    }
    private function bumpColor($index) {
        return ($index < count($this->rowColors) - 1) ? $index + 1 : 0;
    }
}