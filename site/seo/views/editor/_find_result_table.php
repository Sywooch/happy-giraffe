<?php
/* @var $this Controller
 * @var $models Keywords[]
 */
$i=0;

foreach ($models as $model){
    if (Yii::app()->user->getState('hide_used'))
        if ($model->used() || $model->hasOpenedTask())
            continue;
    ?>
<?php $i++; ?>
    <tr id="key-<?=$model->id ?>"<?=$model->getClass() ?>>
        <td class="col-1"><?=$model->name ?></td>
        <td><?=$model->getFreqIcon() ?></td>
        <td><?= isset($model->yandex)?$model->yandex->value:'' ?></td>
        <td></td>
        <td><?= isset($model->pastuhovYandex)?$model->pastuhovYandex->value:'' ?></td>
        <td><?= isset($model->ramblerPopularity)?$model->ramblerPopularity->value:'' ?></td>
<!--        <td></td>-->
<!--        <td></td>-->
        <td><?=$model->getStats(1) ?></td>
        <td><?=$model->getStats(2) ?></td>
        <td>
            <?=$model->getButtons(); ?>
        </td>
    </tr>
<?php if ($i > 200) break; ?>
<?php }
