<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

namespace OURF\Component\Scholarships\Administrator\Helper;

class ScholarshipHelper extends \Joomla\CMS\Helper\ContentHelper
{
    /**
     * Method to filter transitions by given id of state
     *
     * @param   array  $transitions  Array of transitions
     * @param   int    $pk           Id of state
     * @param   int    $workflowId   Id of the workflow
     *
     * @return  array
     *
     * @since   4.0.0
     */
    public static function filterTransitions(array $transitions, int $pk, int $workflowId = 0): array
    {
        return array_values(
            array_filter(
                $transitions,
                function ($var) use ($pk, $workflowId)
                {
                    return in_array($var['from_stage_id'], [-1, $pk]) && $workflowId == $var['workflow_id'];
                }
            )
        );
    }
}