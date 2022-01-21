<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2022 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

\defined('_JEXEC') or die;

// echo '<pre>Items : '.print_r($this->items,true).'</pre><br>';
?>
<table class="table">
    <thead>
    <tr>
        <?php foreach($this->colHeadings as $colName): ?>
        <th scope="col">
            <?php echo $colName; ?>
        </th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->items as $row): ?>
    <tr class="<?php echo $row->color; ?>">
        <?php foreach($row as $col=>$value): ?>
            <?php if(!in_array($col, $this->excludeColumns)): ?>
                <td>
                    <?php echo $value; ?>
                </td>
            <?php endif; ?>
        <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
