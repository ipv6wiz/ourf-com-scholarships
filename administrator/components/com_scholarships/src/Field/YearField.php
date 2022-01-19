<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2022 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Administrator\Field;
\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\ListField;

class YearField extends ListField
{
    public $type = 'Year';
    protected static $options = array();
    protected function getOptions()
    {
        // Accepted modifiers
        $hash = md5($this->element);

        if (!isset(static::$options[$hash]))
        {
            static::$options[$hash] = parent::getOptions();

            $db = Factory::getDbo();

            // Construct the query
            $query = $db->getQuery(true)
                ->select(
                    [
                        'DISTINCT '.$db->quoteName('scholarship_year', 'value'),
                        $db->quoteName('scholarship_year', 'text'),
                    ]
                )
                ->from($db->quoteName('#__scholarships'))
                ->order($db->quoteName('scholarship_year').' DESC');

            // Setup the query
            $db->setQuery($query);

            // Return the result
            if ($options = $db->loadObjectList())
            {
                static::$options[$hash] = array_merge(static::$options[$hash], $options);
            }
        }

        return static::$options[$hash];
    }
}