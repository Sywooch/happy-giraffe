<?php
/**
 * @var site\frontend\modules\comments\modules\contest\controllers\DefaultController $this
 * @var string $content
 */
$this->adaptive = false;
?>

<?php $this->beginContent('//layouts/lite/common_menu'); ?>


        <div class="contest-commentator">
            <!-- Шапка-->
            <div class="contest-commentator-header">
                <div class="contest-commentator-header_date">Сроки проведения:  с <?=Yii::app()->dateFormatter->format('d MMMM', $this->contest->startDate)?> по <?=Yii::app()->dateFormatter->format('d MMMM', $this->contest->endDate)?></div>
                <h1 class="contest-commentator-header_t">Лучший комментатор</h1>
                <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'items' => array(
                            array(
                                'label' => 'Правила',
                                'url' => array('/comments/contest/default/rules', 'contestId' => $this->contest->id),
                                'linkOptions' => array('class' => 'btn btn-xm btn-link'),
                            ),
                            array(
                                'label' => 'О конкурсе',
                                'url' => array('/comments/contest/default/index', 'contestId' => $this->contest->id),
                                'linkOptions' => array('class' => 'btn btn-xxl btn-link'),
                            ),
                            array(
                                'label' => 'Рейтинг',
                                'url' => array('/comments/contest/default/rating', 'contestId' => $this->contest->id),
                                'linkOptions' => array('class' => 'btn btn-xxl btn-link'),
                            ),
                            array(
                                'label' => 'Моя лента',
                                'url' => array('/comments/contest/default/my', 'contestId' => $this->contest->id),
                                'linkOptions' => array('class' => 'btn btn-xm btn-link'),
                                'visible' => ! Yii::app()->user->isGuest && $this->contest->isRegistered(Yii::app()->user->id),
                            ),
                        ),
                        'itemCssClass' => 'contest-commentator-header_li',
                        'htmlOptions' => array(
                            'class' => 'contest-commentator-header_ul',
                        ),
                    ));
                ?>
            </div>
            <!-- Шапка-->
            <?=$content?>
        </div>
        <?php $this->renderPartial('//_footer'); ?>


<?php $this->endContent(); ?>