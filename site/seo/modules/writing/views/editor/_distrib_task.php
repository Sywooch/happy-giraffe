<?php
/* @var $this Controller
 * @var $task SeoTask
 */
?><?php if ($task->rewrite == 0):?>
    <tr data-id="<?=$task->id; ?>">
        <td><?=$task->getText() ?></td>
        <td><?=$task->getExecutor() ?></td>
        <td>
            <a href="" class="icon-remove" onclick="TaskDistribution.removeTask(this);return false;"></a>
            <a href="" class="icon-return" onclick="TaskDistribution.returnTask(this);return false;"></a>
            <a href="" class="icon-updrag" onclick="TaskDistribution.upTask(this);return false;"></a>
            <a href="" class="btn-green-small" onclick="TaskDistribution.readyTask(this);return false;">Ok</a>
        </td>
    </tr>
<?php else: ?>
<tr data-id="<?=$task->id; ?>">
    <td><?=$task->getText() ?></td>
    <td>
        <?php foreach ($task->urls as $url): ?>
        <input name="urls[]" type="text" class="example" value="<?=$url->url?>" data-id="<?=$url->id?>" />
        <br/>
        <?php endforeach; ?>
        <input name="urls[]" type="text" class="example"/><br/>
    </td>
    <td><?=$task->getExecutor() ?></td>
    <td>
        <a href="" class="icon-remove" onclick="TaskDistribution.removeTask(this);return false;"></a>
        <a href="" class="icon-return" onclick="TaskDistribution.returnTask(this);return false;"></a>
        <a href="" class="icon-updrag" onclick="TaskDistribution.upTask(this);return false;"></a>
        <a href="" class="btn-green-small" onclick="TaskDistribution.readyTask(this);return false;">Ok</a>
    </td>
</tr>
<?php endif ?>