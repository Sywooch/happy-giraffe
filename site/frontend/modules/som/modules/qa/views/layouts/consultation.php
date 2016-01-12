<?php
/**
 * @var $this site\frontend\modules\som\modules\qa\controllers\ConsultationController
 * @var string $content
 * @var site\frontend\modules\som\modules\qa\widgets\ConsultationsMenu $consultationsMenu
 */
$this->beginContent('//layouts/lite/main');
?>

    <div class="b-main clearfix">
        <div class="b-main_cont">
            <div class="b-main_col-article">
                <?=$content?>
            </div>
            <aside class="b-main_col-sidebar visible-md">
                <div class="b-consult-specialist">
                    <div class="consult-specialist_img"><img src="/lite/images/services/consult/consult-man.png" alt=""></div>
                    <div class="consult-specialist_name">Морозов Сергей Леонидович</div>
                    <div class="consult-specialist_position">Врач-педиатр</div>
                    <div class="consult-specialist_edu">
                        Кандидат медицинских наук, <br />
                        научный сотрудник Научно-исследовательского <br />
                        клинического института педиатрии <br />
                        ГБОУ ВПО РНИМУ им. Н.И. Пирогова
                    </div>
                    <a href="<?=$this->createUrl('/som/qa/default/questionAddForm/', array('consultationId' => $this->consultation->id))?>" class="consult-specialist_btn btn btn-success btn-xl login-button" data-bind="follow: {}">Задать вопрос</a>
                </div>
            </aside>
        </div>
    </div>
<?php $this->endContent(); ?>