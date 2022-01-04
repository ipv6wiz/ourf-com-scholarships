<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

\defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;
$displayData = [
    'textPrefix' => 'COM_SCHOLARSHIPS',
    'formURL' => 'index.php?option=com_scholarships&view=departments',
    'helpURL' => 'https://github.com/ipv6wiz/ourf-com-scholarships#readme',
    'icon' => 'icon-copy',
];
$user = Factory::getApplication()->getIdentity();
if ($user->authorise('core.create', 'com_scholarships') || count($user->getAuthorisedCategories('com_scholarships', 'core.create')) > 0) {
    $displayData['createURL'] = 'index.php?option=com_scholarships&task=departments.add';
}
echo LayoutHelper::render('joomla.content.emptystate', $displayData);