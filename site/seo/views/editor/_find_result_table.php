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
        <td></td>
        <td></td>
        <td><?= isset($model->yandexPopularity)?$model->yandexPopularity->value:'' ?></td>
        <td><?= isset($model->ramblerPopularity)?$model->ramblerPopularity->value:'' ?></td>
<!--        <td></td>-->
<!--        <td></td>-->
        <td><?=$model->getStats(1) ?></td>
        <td><?=$model->getStats(2) ?></td>
        <td>
            <?php if ($model->inBuffer()):?>
                in-buffer <a href="" class="icon-remove" onclick="SeoKeywords.CancelSelect(this);return false;"></a>
            <?php else: ?>
                <?php if ($model->used()):?>
                    на сайте
                <?php else: ?>
                <?php if ($model->hasOpenedTask()):?>
                    в работе
                    <?php else: ?>
                        <a href="" class="icon-add" onclick="SeoKeywords.Select(this);return false;"></a>
                        <a href="" class="icon-hat" onclick="SeoKeywords.Hide(this);return false;"></a>
                    <?php endif ?>
                <?php endif ?>
            <?php endif ?>
        </td>
    </tr>
<?php if ($i > 200) break; ?>
<?php }
