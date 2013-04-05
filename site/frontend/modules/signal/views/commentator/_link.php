<?php
/**
 * @var $count int порядковый номер ссылки
 * @var $link CommentatorLink ссылка
 */
?>
<tr <?php if ($count % 2 == 0): ?>class="external-link_odd"<?php endif ?>>
    <td class="external-link_td-date">
        <div class="external-link_date"><?=Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($link->created))?></div>
    </td>
    <td class="external-link_td-outer">
        <a href="<?= $link->url ?>" class="external-link_outer" target="_blank"><?=$link->url ?></a>
    </td>
    <td class="external-link_td-inner">
        <?php $article = $link->article();?>
        <?php if ($article !== null): ?>
            <a href="<?= $article->url ?>" class="external-link_inner" target="_blank"><?=$article->title ?></a>
        <?php else: ?>
            Статья не найдена
        <?php endif ?>
    </td>
    <td class="external-link_td-close"><a href="" class="external-link_close" data-id="<?= $link->id ?>"></a></td>
</tr>