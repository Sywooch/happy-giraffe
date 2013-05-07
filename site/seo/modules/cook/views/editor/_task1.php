<?php if ($type == 1): ?>
<tr data-key_id="<?=$keyword->id ?>" data-id="<?=$keyword->id ?>">
    <td class="al"><?=$keyword->name ?> </td>
    <td width="300">
        <?php $this->renderPartial('_urls', array('urls' => array())); ?>
    </td>
    <td><input type="checkbox" name="sub_section"/></td>
    <td>
        <?php $this->renderPartial('_author', compact('authors')); ?>
        <a href="javascript:;" class="icon-remove" style="margin-top:15px;margin-left:20px;" onclick="TaskDistribution.removeFromSelected(this)"></a>
    </td>
</tr>

<?php else: ?>

<tr data-task_id="<?=$by_name_task->id ?>" data-id="<?=$by_name_task->id ?>">
    <td class="al"><?=$by_name_task->article_title ?></td>
    <td width="300">
        <?php $this->renderPartial('_urls', array('urls' => $by_name_task->urls, 'authors'=>$authors)); ?>
    </td>
    <td><input type="checkbox" name="sub_section"/></td>
    <td>
        <?php $this->renderPartial('_author', compact('authors')); ?>
        <a href="javascript:;" class="icon-remove" style="margin-top:15px;margin-left:20px;" onclick="TaskDistribution.removeTask(this);$('.default-nav div.count a').text(parseInt($('.default-nav div.count a').text()) - 1);"></a>
    </td>
</tr>

<?php endif ?>
