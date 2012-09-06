<tr id="task-<?=$task->id ?>">
    <td class="al"><?=$task->getText() ?> <?php if (empty($task->keyword_group_id)):?><span class="sup-h">H</span><?php endif ?></td>
    <td><?php if ($task->multivarka):?><span class="icon-m">M</span><?php endif ?></td>
    <td><?=$task->getExecutor() ?></td>
    <td>
        <a href="javascript:;" class="icon-remove" onclick="TaskDistribution.removeTask(this)"></a>
        <a href="javascript:;" class="icon-return" onclick="TaskDistribution.returnTask(this)"></a>
        <a href="javascript:;" class="btn-green-small" onclick="TaskDistribution.readyTask(this)">Ok</a>
    </td>
</tr>