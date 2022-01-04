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
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Utilities\ArrayHelper;

$user      = Factory::getUser();
$userId = $user->id;
$workflow_enabled  = ComponentHelper::getParams('com_scholarships')->get('workflow_enabled');
$workflow_state    = false;
$workflow_featured = false;

if ($workflow_enabled) :

// @todo move the script to a file
    $js = <<<JS
(function() {
	document.addEventListener('DOMContentLoaded', function() {
	  var elements = [].slice.call(document.querySelectorAll('.scholarship-status'));

	  elements.forEach(function (element) {
		element.addEventListener('click', function(event) {
			event.stopPropagation();
		});
	  });
	});
})();
JS;

    /** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
    $wa = $this->document->getWebAssetManager();

    $wa->getRegistry()->addExtensionRegistryFile('com_workflow');
    $wa->useScript('com_workflow.admin-items-workflow-buttons')
        ->addInlineScript($js, [], ['type' => 'module']);

    $workflow_state    = Factory::getApplication()->bootComponent('com_scholarships')->isFunctionalityUsed('core.state', 'com_scholarships.status');
    // $workflow_featured = Factory::getApplication()->bootComponent('com_scholarships')->isFunctionalityUsed('core.featured', 'com_scholarships.scholarship');
    // echo '<pre>WF State : '.$workflow_state.'</pre><br>';
endif;
?>
<form action="<?php echo Route::_('index.php?option=com_scholarships&view=statuses'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="row">
        <div class="col-md-12">
            <div id="j-main-container" class="j-main-container">
                <?php if (empty($this->items)) : ?>
                    <div class="alert alert-warning">
                        <?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                    </div>
                <?php else : ?>
                    <table class="table" id="scholarshipStatusList">
                        <thead>
                        <tr>
                            <td class="w-1 text-center">
                                <?php echo HTMLHelper::_('grid.checkall'); ?>
                            </td>
                            <th scope="col">
                                <?php echo Text::_('COM_SCHOLARSHIPS_STATUS_TABLE_TABLEHEAD_OPTION'); ?>
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
                            $canEdit          = $user->authorise('core.edit',       'com_scholarships.status.' . $item->id);
                            $canCheckin       = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || is_null($item->checked_out);
                            $canEditOwn       = $user->authorise('core.edit.own',   'com_scholarships.status.' . $item->id) && $item->created_by == $userId;
                            $canChange        = $user->authorise('core.edit.state', 'com_scholarships.status.' . $item->id) && $canCheckin;
                            ?>
                            <tr class="row<?php echo $i % 2; ?>">
                                <td class="text-center">
                                    <?php echo HTMLHelper::_('grid.id', $i, $item->id, false, 'cid', 'cb', $item->option); ?>
                                </td>
                                <th scope="row" class="has-context">
                                    <?php $editIcon = '<span class="fa fa-pencil-square mr-2" aria-hidden="true"></span>'; ?>
                                    <a class="hasTooltip" href="<?php echo Route::_('index.php?option=com_scholarships&task=status.edit&id=' . (int) $item->id); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->option)); ?>">
                                        <?php echo $editIcon; ?><?php echo $this->escape($item->option); ?></a>
                                </th>
                                <td class="scholarship-status text-center">
                                    <?php
                                    $options = [
                                        'task_prefix' => 'statuses.',
                                        'disabled' => $workflow_state || !$canChange,
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