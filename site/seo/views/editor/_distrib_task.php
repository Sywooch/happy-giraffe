<tr id="task-<?=$task->id; ?>">
    <td><?=$task->getText() ?></td>
    <td><?=$task->getIcon() ?> <span class="admin-name"><?php if (!empty($task->executor_id)) echo $task->executor->name ?></span></td>
    <td>
        <a href="" class="icon-remove" onclick="TaskDistribution.removeTask(this);return false;"></a>
        <a href="" class="icon-return" onclick="TaskDistribution.returnTask(this);return false;"></a>
        <a href="" class="icon-updrag" onclick="TaskDistribution.upTask(this);return false;"></a>
        <a href="" class="btn-green-small" onclick="TaskDistribution.readyTask(this);return false;">Ok</a>
    </td>
</tr>