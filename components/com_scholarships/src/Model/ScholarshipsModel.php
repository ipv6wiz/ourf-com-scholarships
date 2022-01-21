<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2022 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace Joomla\Component\Scholarships\Site\Model;

\defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\AssociationHelper;
use Joomla\Database\ParameterType;
use Joomla\Registry\Registry;
use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;

class ScholarshipsModel extends ListModel
{
    public function __construct($config = array(), MVCFactoryInterface $factory = null)
    {
        $this->app = Factory::getApplication();
        parent::__construct($config, $factory);
    }

    protected function populateState($ordering = 'ordering', $direction = 'ASC')
    {
        $app = Factory::getApplication();

        // List state information
        $value = $app->input->get('limit', $app->get('list_limit', 0), 'uint');
        $this->setState('list.limit', $value);

        $value = $app->input->get('limitstart', 0, 'uint');
        $this->setState('list.start', $value);

        $value = $app->input->get('filter_tag', 0, 'uint');
        $this->setState('filter.tag', $value);

        $orderCol = $app->input->get('filter_order', 'a.ordering');

        if (!in_array($orderCol, $this->filter_fields))
        {
            $orderCol = 'a.ordering';
        }

        $this->setState('list.ordering', $orderCol);

        $listOrder = $app->input->get('filter_order_Dir', 'ASC');

        if (!in_array(strtoupper($listOrder), array('ASC', 'DESC', '')))
        {
            $listOrder = 'ASC';
        }

        $this->setState('list.direction', $listOrder);

        $params = $app->getParams();
        $this->setState('params', $params);
        $user = Factory::getUser();

        if ((!$user->authorise('core.edit.state', 'com_content')) && (!$user->authorise('core.edit', 'com_content')))
        {
            // Filter on published for those who do not have edit or edit.state rights.
            $this->setState('filter.published', ContentComponent::CONDITION_PUBLISHED);
        }

        $this->setState('filter.language', Multilanguage::isEnabled());

        // Process show_noauth parameter
        if ((!$params->get('show_noauth')) || (!ComponentHelper::getParams('com_content')->get('show_noauth')))
        {
            $this->setState('filter.access', true);
        }
        else
        {
            $this->setState('filter.access', false);
        }

        $this->setState('layout', $app->input->getString('layout'));
    }

    protected function getStoreId($id = '')
    {
        // Compile the store id.
        $id .= ':' . serialize($this->getState('filter.published'));
        $id .= ':' . $this->getState('filter.access');
        $id .= ':' . $this->getState('filter.featured');
        $id .= ':' . serialize($this->getState('filter.article_id'));
        $id .= ':' . $this->getState('filter.article_id.include');
        $id .= ':' . serialize($this->getState('filter.category_id'));
        $id .= ':' . $this->getState('filter.category_id.include');
        $id .= ':' . serialize($this->getState('filter.author_id'));
        $id .= ':' . $this->getState('filter.author_id.include');
        $id .= ':' . serialize($this->getState('filter.author_alias'));
        $id .= ':' . $this->getState('filter.author_alias.include');
        $id .= ':' . $this->getState('filter.date_filtering');
        $id .= ':' . $this->getState('filter.date_field');
        $id .= ':' . $this->getState('filter.start_date_range');
        $id .= ':' . $this->getState('filter.end_date_range');
        $id .= ':' . $this->getState('filter.relative_date');
        $id .= ':' . serialize($this->getState('filter.tag'));

        return parent::getStoreId($id);
    }

    protected function getListQuery()
    {
        $user = $this->app->getIdentity();
        $db = $this->getDbo();
        $query = $db->getQuery(true);
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
                    $db->quoteName('scholarship_topic'),
                    $db->quoteName('scholarship_employment'),
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
                $db->quoteName('a.state', 'state'),
            ])
            ->from($db->quoteName('#__scholarships', 'a'))
            ->join('LEFT', $db->quoteName('#__scholarship_status', 'b'), $db->quoteName('scholarship_fk_scholarship_status').' = '.$db->quoteName('b.id'))
            ->join('LEFT', $db->quoteName('#__scholarship_colleges', 'c'), $db->quoteName('scholarship_fk_scholarship_college').' = '.$db->quoteName('c.id'))
            ->join('LEFT', $db->quoteName('#__scholarship_departments', 'd'), $db->quoteName('scholarship_fk_scholarship_department').' = '.$db->quoteName('d.id'))
            ->join('LEFT', $db->quoteName('#__languages', 'l'), $db->quoteName('l.lang_code') . ' = ' . $db->quoteName('a.language'))
            ->join('LEFT', $db->quoteName('#__users', 'ua'), $db->quoteName('ua.id') . ' = ' . $db->quoteName('a.created_by'))
            ->join('LEFT', $db->quoteName('#__categories', 'e'), $db->quoteName('e.id').' =  '.$db->quoteName('a.catid'));

        // Filter by published state
        $published = (string) $this->getState('filter.published');

        if ($published !== '*')
        {
            if (is_numeric($published))
            {
                $state = (int) $published;
                $query->where($db->quoteName('a.state') . ' = :state')
                    ->bind(':state', $state, ParameterType::INTEGER);
            }
//            elseif (!is_numeric($workflowStage))
//            {
//                $query->whereIn(
//                    $db->quoteName('a.state'),
//                    [
//                        ContentComponent::CONDITION_PUBLISHED,
//                        ContentComponent::CONDITION_UNPUBLISHED,
//                    ]
//                );
//            }
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
        echo '<pre>College: '.print_r($college,true).'</pre><br>';
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