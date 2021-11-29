<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

\defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;

echo Text::_('COM_SCHOLARSHIPS_RECIPIENT').$this->item->recipient;