<tr>
    <td class="col-1"><?=$model->number ?></td>
    <td><b><?=isset($model->article)?$model->article->title:'' ?></b><br/><a target="_blank" href="<?=$model->url ?>"><?=$model->url ?></a></td>
    <td><?=$model->getKeywords() ?></td>
    <?php if (Yii::app()->user->checkAccess('admin')):?>
        <td><a href="#" onclick="SeoModule.removeArticle(this, <?=$model->id ?>)">remove</a></td>
    <?php endif ?>
</tr>