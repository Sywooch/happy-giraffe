<?php
use site\frontend\modules\comments\modules\contest\components\ContestHelper;

$this->pageTitle = $this->contest->name;
/**
 * @var \CActiveDataProvider $dp
 * @var int $participantsCount
 * @var int $commentsCount
 * @var int $count
 */
?>

<div class="b-contest__block textalign-c">
    <div class="b-contest__title">Пульс конкурса</div>
    <p class="b-contest__p margin-t10 margin-b30">В конкурсе принимают участие <?= $participantsCount ?> участников, они написали уже <?= $commentsCount ?> комментариев</p>
    <div class="b-main_cont-contest textalign-l">
    <?php
        $this->widget('LiteListView', [
            'dataProvider'  => $dp,
            'itemView'      => '/_comment',
            'itemsTagName' => 'ul',
            'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
            'pager' => [
                'class'           => 'LitePagerDots',
                'prevPageLabel'   => '&nbsp;',
                'nextPageLabel'   => '&nbsp;',
                'showPrevNext'    => TRUE,
                'showButtonCount' => 5,
                'dotsLabel'       => '<li class="page-points">...</li>'
            ]
        ]);
    ?>
    </div>
</div>
