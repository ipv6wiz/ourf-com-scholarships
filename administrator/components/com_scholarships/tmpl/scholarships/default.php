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
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Utilities\ArrayHelper;

HTMLHelper::_('behavior.multiselect');

$app       = Factory::getApplication();
$user      = Factory::getUser();
$userId = $user->id;
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'scholarship_year';
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

    $workflow_state    = Factory::getApplication()->bootComponent('com_scholarships')->isFunctionalityUsed('core.state', 'com_scholarships.scholarship');
    $workflow_featured = Factory::getApplication()->bootComponent('com_scholarships')->isFunctionalityUsed('core.featured', 'com_scholarships.scholarship');
    // echo '<pre>WF State : '.$workflow_state.'</pre><br>';
endif;
$this->document->addScript("https://www.gstatic.com/charts/loader.js");
foreach ($this->charts as $chart ) {
    $this->document->addCustomTag($chart);
}

?>
<div class="accordion" id="scholarshipsAccordion">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Scholarship Statistics
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="row">
                    <div class="col">
                        <div id="chart_1"></div>
                    </div>
                    <div class="col">
                        <div id="chart_2"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div id="chart_3"></div>
                    </div>
                    <div class="col">
<!--                        <div id="chart_2"></div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Scholarship Details
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <form action="<?php echo Route::_('index.php?option=com_scholarships'); ?>" method="post" name="adminForm" id="adminForm">
                <div class="row">
                    <div class="col-md-12">
                        <div id="j-main-container" class="j-main-container">
                            <?php
                            // Search tools bar
                            echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this));
                            ?>
                            <?php if (empty($this->items)) : ?>
                                <div class="alert alert-warning">
                                    <?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                                </div>
                            <?php else : ?>
                                <table class="table" id="scholarshipList">
                                    <thead>
                                    <tr>
                                        <td class="w-1 text-center">
                                            <?php echo HTMLHelper::_('grid.checkall'); ?>
                                        </td>
                                        <th scope="col" style="width:1%" class="text-center d-none d-md-table-cell">
                                            <?php echo HTMLHelper::_('searchtools.sort','COM_SCHOLARSHIPS_TABLE_TABLEHEAD_YEAR','scholarship_year', $listDirn, $listOrder); ?>
                                        </th>
                                        <th scope="col">
                                            <?php echo HTMLHelper::_('searchtools.sort','COM_SCHOLARSHIPS_TABLE_TABLEHEAD_RECIPIENT', 'scholarship_recipient', $listDirn, $listOrder); ?>
                                        </th>
                                        <th scope="col">
                                            <?php echo HTMLHelper::_('searchtools.sort','COM_SCHOLARSHIPS_TABLE_TABLEHEAD_COLLEGE', 'scholarship_college_name', $listDirn, $listOrder); ?>
                                        </th>
                                        <th scope="col">
                                            <?php echo HTMLHelper::_('searchtools.sort','COM_SCHOLARSHIPS_TABLE_TABLEHEAD_DEPARTMENT', 'scholarship_department_name', $listDirn, $listOrder); ?>
                                        </th>
                                        <th scope="col">
                                            <?php echo Text::_('COM_SCHOLARSHIPS_TABLE_TABLEHEAD_STATUS'); ?>
                                        </th>
                                        <th scope="col">
                                            <?php echo Text::_('COM_SCHOLARSHIPS_TABLE_TABLEHEAD_PUBLISHED'); ?>
                                        </th>
                                        <th scope="col">
                                            <?php echo HTMLHelper::_('searchtools.sort','COM_SCHOLARSHIPS_TABLE_TABLEHEAD_ID','a.id', $listDirn, $listOrder); ?>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $n = count($this->items);
                                    foreach ($this->items as $i => $item) :
                                        $item->max_ordering = 0;
                                        $canEdit          = $user->authorise('core.edit',       'com_scholarships.scholarship.' . $item->id);
                                        $canCheckin       = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || is_null($item->checked_out);
                                        $canEditOwn       = $user->authorise('core.edit.own',   'com_scholarships.scholarship.' . $item->id) && $item->created_by == $userId;
                                        $canChange        = $user->authorise('core.edit.state', 'com_scholarships.scholarship.' . $item->id) && $canCheckin;
                                        $canEditCat       = $user->authorise('core.edit',       'com_scholarships.category.' . $item->catid);
                                        $canEditOwnCat    = $user->authorise('core.edit.own',   'com_scholarships.category.' . $item->catid) && $item->category_uid == $userId;
                                        $canEditParCat    = $user->authorise('core.edit',       'com_scholarships.category.' . $item->parent_category_id);
                                        $canEditOwnParCat = $user->authorise('core.edit.own',   'com_scholarships.category.' . $item->parent_category_id) && $item->parent_category_uid == $userId;
                                        ?>
                                        <tr class="row<?php echo $i % 2; ?>">
                                            <td class="text-center">
                                                <?php echo HTMLHelper::_('grid.id', $i, $item->id, false, 'cid', 'cb', $item->recipient); ?>
                                            </td>
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
                                            <td class="scholarship-status text-center">
                                                <?php
                                                $options = [
                                                    'task_prefix' => 'scholarships.',
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
                                <?php // load the pagination. ?>
                                <?php echo $this->pagination->getListFooter(); ?>
                            <?php endif; ?>
                            <input type="hidden" name="task" value="">
                            <input type="hidden" name="boxchecked" value="0">
                            <?php echo HTMLHelper::_('form.token'); ?>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
