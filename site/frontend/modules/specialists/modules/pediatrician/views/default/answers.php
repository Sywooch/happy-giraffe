<?php
/**
 * @var LiteController $this
 * @var CActiveDataProvider $dp
 */
$this->pageTitle = 'Жираф педиатр - Ответы';
?>

<div class="landing-question pediator pediator-top">

    <?php
    $this->widget('LiteListView', array(
        'htmlOptions' => ['class' => 'questions margin-t0'],
        'dataProvider' => $dp,
        'itemView' => '_answer',
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
    ));
    ?>
</div>