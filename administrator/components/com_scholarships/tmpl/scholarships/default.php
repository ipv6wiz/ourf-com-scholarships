<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Button\PublishedButton;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Utilities\ArrayHelper;

$user      = Factory::getUser();
$userId = $user->id;
?>
<form action="<?php echo Route::_('index.php?option=com_scholarships'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="row">
        <div class="col-md-12">
            <div id="j-main-container" class="j-main-container">
                <?php if (empty($this->items)) : ?>
                    <div class="alert alert-warning">
                        <?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                    </div>
                <?php else : ?>
                    <table class="table" id="scholarshipList">
                        <thead>
                        <tr>
                            <th scope="col" style="width:1%" class="text-center d-none d-md-table-cell">
                                <?php echo Text::_('COM_SCHOLARSHIPS_TABLE_TABLEHEAD_YEAR'); ?>
                            </th>
                            <th scope="col">
                                <?php echo Text::_('COM_SCHOLARSHIPS_TABLE_TABLEHEAD_RECIPIENT'); ?>
                            </th>
                            <th scope="col">
                                <?php echo Text::_('COM_SCHOLARSHIPS_TABLE_TABLEHEAD_COLLEGE'); ?>
                            </th>
                            <th scope="col">
                                <?php echo Text::_('COM_SCHOLARSHIPS_TABLE_TABLEHEAD_DEPARTMENT'); ?>
                            </th>
                            <th scope="col">
                                <?php echo Text::_('COM_SCHOLARSHIPS_TABLE_TABLEHEAD_STATUS'); ?>
                            </th>
                            <th scope="col">
                                <?php echo Text::_('COM_SCHOLARSHIPS_TABLE_TABLEHEAD_PUBLISHED'); ?>
                            </th>
                            <th scope="col">
                                <?php echo Text::_('COM_SCHOLARSHIPS_TABLE_TABLEHEAD_ID'); ?>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = count($this->items);
                        foreach ($this->items as $i => $item) :
                            $item->max_ordering = 0;
                            $canEdit          = $user->authorise('core.edit',       'com_content.article.' . $item->id);
                            $canCheckin       = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || is_null($item->checked_out);
                            $canEditOwn       = $user->authorise('core.edit.own',   'com_content.article.' . $item->id) && $item->created_by == $userId;
                            $canChange        = $user->authorise('core.edit.state', 'com_content.article.' . $item->id) && $canCheckin;
                            $canEditCat       = $user->authorise('core.edit',       'com_content.category.' . $item->catid);
                            $canEditOwnCat    = $user->authorise('core.edit.own',   'com_content.category.' . $item->catid) && $item->category_uid == $userId;
                            $canEditParCat    = $user->authorise('core.edit',       'com_content.category.' . $item->parent_category_id);
                            $canEditOwnParCat = $user->authorise('core.edit.own',   'com_content.category.' . $item->parent_category_id) && $item->parent_category_uid == $userId;
                            ?>
                            <tr class="row<?php echo $i % 2; ?>">
                                <td class="d-none d-md-table-cell">
                                    <?php echo $item->year; ?>
                                </td>
                                <th scope="row" class="has-context">
                                    <?php $editIcon = '<span class="fa fa-pencil-square mr-2" aria-hidden="true"></span>'; ?>
                                    <a class="hasTooltip" href="<?php echo Route::_('index.php?option=com_scholarships&task=scholarship.edit&id=' . (int) $item->id); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->recipient)); ?>">
                                        <?php echo $editIcon; ?><?php echo $this->escape($item->recipient); ?></a>
                                </th>
                                <td class="d-none d-md-table-cell">
                                    <?php echo $item->college; ?>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <?php echo $item->department; ?>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <?php echo $item->status; ?>
                                </td>
                                <td class="article-status text-center">
                                    <?php
                                    $options = [
                                        'task_prefix' => 'scholarships.',
                                        'id' => 'state-' . $item->id
                                    ];
                                    // echo "<pre>".print_r($item,true)."</pre><br>";
                                    echo (new PublishedButton)->render((int) $item->state, $i, $options, $item->publish_up, $item->publish_down);
                                    ?>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <?php echo $item->id; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <input type="hidden" name="task" value="">
                <input type="hidden" name="boxchecked" value="0">
                <?php echo HTMLHelper::_('form.token'); ?>
            </div>
        </div>
    </div>
</form>