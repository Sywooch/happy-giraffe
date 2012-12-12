<?php
/* @var $this Controller
 * @var $models Keyword[]
 */
foreach ($models as $model):?>
<tr id="key-<?=$model->id ?>" class="<?=$model->getClass() ?>">
    <td class="col-1"><?=$model->getKeywordAndSimilarArticles() ?></td>
    <td><?=$model->getFreqIcon() ?></td>
    <td><?= isset($model->yandex) ? $model->yandex->value : '' ?></td>
    <td></td>
    <td><?=$model->getStats(1) ?></td>
    <td><?=$model->getStats(2) ?></td>
    <td>
        <?=$model->getButtons(); ?>
    </td>
</tr>
<?php endforeach;