<?php

/**
 * @var LiteController $this
 * @var CActiveDataProvider $dp
 * @var boolean $authorizationIsDone
 * @var boolean $photoUploadIsDone
 * @var boolean $pactIsDone
 */
$this->pageTitle = 'Жираф педиатр - Вопросы';
?>


<div class="landing-question pediator pediator-top">
   <?php
        $this->widget('\site\frontend\modules\specialists\modules\pediatrician\widgets\SpecialistStatistic', [
            'viewName' => 'statistic'
        ]);

        $this->widget('\site\frontend\modules\specialists\modules\pediatrician\widgets\ListView', [
            'htmlOptions' => ['class' => 'questions questions-modification'],
            'dataProvider' => $dp,
            'itemView' => '_question',
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