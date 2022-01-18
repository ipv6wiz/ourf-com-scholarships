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

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Associations;
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

    /**
     * Get the filter form
     *
     * @param   array    $data      data
     * @param   boolean  $loadData  load current data
     *
     * @return  \Joomla\CMS\Form\Form  The \JForm object or null if the form can't be found
     *
     * @since   3.2
     */
    public function getFilterForm($data = array(), $loadData = true)
    {
        $form = parent::getFilterForm($data, $loadData);

/*        $params = ComponentHelper::getParams('com_scholarships');

        if (!$params->get('workflow_enabled'))
        {
            $form->removeField('stage', 'filter');
        }
        else
        {
            $ordering = $form->getField('fullordering', 'list');

            $ordering->addOption('JSTAGE_ASC', ['value' => 'ws.title ASC']);
            $ordering->addOption('JSTAGE_DESC', ['value' => 'ws.title DESC']);
        }*/

        return $form;
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param   string  $ordering   An optional ordering field.
     * @param   string  $direction  An optional direction (asc|desc).
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function populateState($ordering = 'a.year', $direction = 'desc')
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

        $featured = $this->getUserStateFromRequest($this->context . '.filter.featured', 'filter_featured', '');
        $this->setState('filter.featured', $featured);

        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);

        $language = $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '');
        $this->setState('filter.language', $language);

        $formSubmited = $app->input->post->get('form_submited');

        // Gets the value of a user state variable and sets it in the session
        $this->getUserStateFromRequest($this->context . '.filter.scholarship_recipient', 'filter_scholarship_recipient');
        $this->getUserStateFromRequest($this->context . '.filter.scholarship_college_name', 'filter_scholarship_college_name');
        $this->getUserStateFromRequest($this->context . '.filter.scholarship_department_name', 'filter_scholarship_department_name', '');

        if ($formSubmited)
        {
            $authorId = $app->input->post->get('scholarship_recipient');
            $this->setState('filter.scholarship_recipient', $authorId);

            $categoryId = $app->input->post->get('scholarship_college_name');
            $this->setState('filter.scholarship_department_name', $categoryId);

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
        $user  = Factory::getUser();

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
                    $db->quoteName('a.featured'),
                    $db->quoteName('a.language'),
                    $db->quoteName('a.catid'),
                    $db->quoteName('a.alias'),
                    $db->quoteName('a.language'),
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