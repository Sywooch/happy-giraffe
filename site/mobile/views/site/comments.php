<?php
/*
 * @var $data CommunityContent
 * @var $comments CActiveDataProvider
 */

$pagination = $comments->pagination;
?>

<div class="entry">
    <div class="margin-b10">
        <?=CHtml::link($data->mobileSectionTitle, $data->mobileSectionUrl, array('class' => 'text-small'))?>
    </div>
    <div class="entry_h clearfix">
        <h1 class="entry_h1"><?=CHtml::link($data->title, $data->url)?></h1>

    </div>

    <div class="margin-b10">
				<span class="color-lilac">
				&larr;
                    <?=CHtml::link('Вернуться к записи', $data->url)?>
				</span>
    </div>
    <div class="comments">
        <h2 class="comments_t">Комментарии <span class="comments_count">(<?=$data->getUnknownClassCommentsCount()?>)</span>	</h2>

        <?php $this->widget('MListView', array(
            'dataProvider' => $comments,
            'itemView' => '_comment',
            'template' => "{summary}\n{sorter}\n{items}",
    )); ?>
    </div>

</div>

<?php if ($pagination->currentPage < $pagination->pageCount - 1): ?>
    <div class="margin-10 textalign-c clearfix">
        <a href="<?=$pagination->createPageUrl($this, $pagination->currentPage + 1)?>" class="btn-green btn-medium">Показать еще 10 <i class="ico-arrow ico-arrow__down"></i></a>
    </div>
<?php endif; ?>