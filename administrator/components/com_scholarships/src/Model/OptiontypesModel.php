<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2022 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */
namespace OURF\Component\Scholarships\Administrator\Model;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\Database\ParameterType;

\defined('_JEXEC') or die;

class OptiontypesModel extends ListModel
{
    private string $componentName = 'com_scholarships';
    private string $tableName = '';
    private string $tName = 'Optiontype';
    protected array $colHeadings = [

    ];

    public function __construct($config = array())
    {
//        $this->app = Factory::getApplication();
//        if (empty($config['filter_fields'])) {
//           $config['filter_fields'] = array(
//               'id', 'a.id',
//               'name', 'opt_type_name'
//           );
//        }
        parent::__construct($config);
        $this->tableName = $this->getTable($this->tName)->getTableName();
    }

    public function getFilterForm($data = array(), $loadData = true)
    {
        return parent::getFilterForm($data, $loadData);
    }

    /**
     * @throws \Exception
     * @since
     */
    protected function populateState($ordering = 'ordering', $direction = 'asc')
    {
        $app = Factory::getApplication();
        // Adjust the context to support modal layouts.
        if ($layout = $app->input->get('layout'))
        {
            $this->context .= '.' . $layout;
        }
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);
        $formSubmited = $app->input->post->get('form_submited');
        $this->getUserStateFromRequest($this->context.'filter.opt_type_name', 'filter_opt_type_name');
        if($formSubmited) {
            $name = $app->input->post-get('opt_type_name');
            $this->setState('filter.opt_type_name', $name);
        }

        parent::populateState($ordering, $direction); // TODO: Change the autogenerated stub
    }

    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select([
            $db->quoteName('id'),
            $db->quoteName('opt_type_name', 'name'),
            $db->quoteName('state')
        ])
            -> from($db->quoteName($this->tableName));
        return $query;
    }

//    protected function getListQuery()
//    {
//        $db = $this->getDbo();
//        $query = $db->getQuery(true);
//        $user = $this->app->getIdentity();
//        $params = ComponentHelper::getParams('com_scholarships');
//        $query->select(
//            $this->getState(
//                'list.select',
//                [
//                    $db->quoteName('a.id'),
//                    $db->quoteName('a.state'),
//                    $db->quoteName('a.ordering'),
//                ]
//            )
//        )
//        ->select([
//            $db->quoteName('a.id', 'id'),
//            $db->quoteName('a.opt_type_name', 'name'),
//            $db->quoteName('a.state', 'state'),
//        ])
//        ->from($db->quoteName('#__scholarship_option_types'));
//
//        // Filter by published state
//        $published = (string) $this->getState('filter.published');
//        if ($published !== '*')
//        {
//            if (is_numeric($published))
//            {
//                $state = (int) $published;
//                $query->where($db->quoteName('a.state') . ' = :state')
//                    ->bind(':state', $state, ParameterType::INTEGER);
//            }
//        }
//
//        //filter by Option Type Name
//        $name = $this->getState('filter.opt_type_name');
//        if(!empty($name)) {
//            if(is_string($name)) {
//                $query->where($db->quoteName('opt_type_name').' = '.':name')
//                    ->bind(':name', $name, ParameterType::STRING);
//            } elseif (is_array($name)) {
//                $query->whereIn($db->quoteName('opt_type_name'), $name, ParameterType::STRING);
//            }
//        }
//
//        // Filter by Search in Name
//        $search = $this->getState('filter.search');
//        if(!empty($search)) {
//            if (stripos($search, 'id:') === 0)
//            {
//                $search = (int) substr($search, 3);
//                $query->where($db->quoteName('a.id') . ' = :search')
//                    ->bind(':search', $search, ParameterType::INTEGER);
//            }
//            elseif (stripos($search, 'name:') === 0)
//            {
//                $search = '%'.substr($search, strlen('name:')) . '%';
//                $query->where('('.$db->quoteName('opt_type_name').' LIKE :search1')
//                ->bind('search1', $search);
//            } else {
//                $search = '%' . str_replace(' ', '%', trim($search)) . '%';
//                $query->where(
//                    '(' . $db->quoteName('opt_type_name') . ' LIKE :search1 )'
//                )
//                    ->bind(':search1', $search);
//            }
//        }
//        // Add the list ordering clause.
//        $orderCol  = $this->state->get('list.ordering', 'ordering');
//        $orderDirn = $this->state->get('list.direction', 'DESC');
//
//        $ordering = $db->escape($orderCol) . ' ' . $db->escape($orderDirn);
//
//        $query->order($ordering);
//        return $query;
//    }

    public function getItems()
    {
        $items = parent::getItems();
        return (is_array($items) ? $items : []);
    }
}