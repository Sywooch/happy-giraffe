<?php
/**
 * @var $this site\frontend\modules\som\modules\qa\controllers\MyController
 * @var string $content
 */
$this->beginContent('//layouts/lite/main');
?>

    <div class="b-main clearfix">
        <div class="b-main_cont">
            <div class="b-main_col-article">
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Мои вопросы',
                            'url' => array('/som/qa/my/questions'),
                        ),
                        array(
                            'label' => 'Мои ответы',
                            'url' => array('/som/qa/my/answers'),
                        ),
                    ),
                ));
                ?>

                <?=$content?>
            </div>
            <aside class="b-main_col-sidebar visible-md">
                <div class="questions-categories">
                    <?php $this->widget('site\frontend\modules\som\modules\qa\widgets\categories\MyQuestionsMenu', array(
                        'userId' => Yii::app()->user->id,
                    )); ?>

                    <?php $this->widget('site\frontend\modules\som\modules\qa\widgets\categories\MyAnswersMenu', array(
                        'userId' => Yii::app()->user->id,
                    )); ?>
                </div>
            </aside>
        </div>
    </div>
<?php $this->endContent(); ?>