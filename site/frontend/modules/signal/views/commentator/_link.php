<?php
/**
 * @var $count int порядковый номер ссылки
 * @var $link CommentatorLink ссылка
 */
?>
<tr <?php if ($count % 2 == 0):?>class="external-link_odd"<?php endif ?>>
<td class="external-link_td-date">
    <div class="external-link_date"><?=Yii::app()->dateFormatter->format('d MMM yyyy',strtotime($link->created))?></div>
</td>
<td class="external-link_td-outer">
    <a href="<?=$link->url ?>" class="external-link_outer" target="_blank"><?=$link->url ?></a>
</td>
<td class="external-link_td-count">
    <div class="external-link_count"><?=$link->count ?></div>
</td>
<td class="external-link_td-inner">
    <?php $article = $link->article() ?>
    <?php if ($article !== null):?>
        <a href="<?=$article->url ?>" class="external-link_inner" target="_blank"><?=$article->title ?></a>
    <?php else: ?>
        Статья не найдена
    <?php endif ?>
</td>
</tr>