<tr data-id="<?=$task->id ?>">
    <td class="al"><?=$task->getText() ?></td>
    <td><?php if ($task->sub_section == 1):?><span class="icon-m">M</span><?php endif ?></td>
    <td><?=$task->executor->name ?></td>
    <td data-id="<?=$task->id ?>">
        <a href="javascript:;" class="icon-remove" onclick="TaskDistribution.removeTask(this)"></a>
        <a href="javascript:;" class="icon-return" onclick="CookModule.returnTask(this)"></a>
        <a href="javascript:;" class="btn-green-small" onclick="TaskDistribution.readyTask(this)">Ok</a>
    </td>
</tr>