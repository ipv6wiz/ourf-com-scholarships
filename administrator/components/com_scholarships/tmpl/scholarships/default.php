<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage  com_scholarships
 *
 * @copyright   Copyright (C) 2006 - 2021 MultiMediaCommunications. All rights reserved.
 * @license     GPL2
 */

\defined('_JEXEC') or die;
?>
<table>
<?php foreach ($this->items as $i=> $item): ?>
    <tr>
        <?php foreach ($item as $key => $col): ?>
            <td><?php echo $col; ?></td>
        <?php endforeach; ?>
    </tr>
<?php endforeach; ?>
</table>