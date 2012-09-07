<?php if ($type == 1): ?>
<tr data-key_id="<?=$keyword->id ?>">
    <td class="al"><?=$keyword->name ?> </td>
    <td width="300">
        <input type="text" name="urls[]" class="example"/><br/>
    </td>
    <td><input type="checkbox" name="multivarka"/></td>
    <td>
        <?php $this->renderPartial('_author'); ?>
    </td>
</tr>

<?php else: ?>

<tr data-task_id="<?=$by_name_task->id ?>">
    <td class="al"><?=$by_name_task->article_title ?></td>
    <td width="300">
        <?php $this->renderPartial('_urls', array('urls' => $by_name_task->urls)); ?>
    </td>
    <td><input type="checkbox" name="multivarka"/></td>
    <td>
        <?php $this->renderPartial('_author'); ?>
    </td>
</tr>

<?php endif ?>
