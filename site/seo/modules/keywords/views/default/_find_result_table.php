<?php
/* @var $this Controller
 * @var $models Keyword[]
 */
foreach ($models as $model):?>
<tr id="key-<?=$model->id ?>">
    <td class="col-1"><?=$model->name ?></td>
    <td><?=$model->getFreqIcon() ?></td>
    <td><?= $model->wordstat ?></td>
    <td>
        <?=$model->getButtons(); ?>
    </td>
</tr>
<?php endforeach;