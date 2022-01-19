<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2022 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Field;
\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\ListField;

class RecipientField extends ListField
{
    public $type = 'Recipient';
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
                        $db->quoteName('id', 'value'),
                        $db->quoteName('scholarship_recipient', 'text'),
                    ]
                )
                ->from($db->quoteName('#__scholarships'))
                ->order($db->quoteName('scholarship_recipient'));

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