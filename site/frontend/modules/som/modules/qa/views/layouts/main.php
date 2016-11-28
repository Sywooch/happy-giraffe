<?php
/**
 * @var $this site\frontend\modules\som\modules\qa\controllers\DefaultController
 * @var string $content
 * @var site\frontend\modules\som\modules\qa\widgets\ConsultationsMenu $consultationsMenu
 */
$this->beginContent('//layouts/lite/main');
$this->renderSidebarClip();

?>
    <div class="b-main">
        <div class="mobile-header">
            <div class="mobile-header__title mobile-header__title_answer">Ответы</div>
            <div class="mobile-header__btn btn-wrapper"><a href="<?=$this->createUrl('/som/qa/default/questionAddForm/')?>" class="btn-wrapper__link">+</a></div>
    	</div>
        <div class="b-main_cont">

            <?php if (FALSE === isset($this->isQuestion)): ?>

                <div class="heading-link-xxl"><?php echo $this->pageTitle; ?></div>

            <?php endif; ?>
            <div class="b-main_col-article position-rel clearfix">
                <?=$content?>
            </div>

            <aside style="margin-top: 35px" class="b-main_col-sidebar visible-md">
                <div class="sidebar-widget sidebar-widget__padding">
                    <?php $this->renderPartial('/_sidebar/ask', array());?>
                    <?php //$this->renderPartial('/_sidebar/personal', array());?>
                    <?php $this->renderPartial('/_sidebar/menu', array());?>
                    <?php $this->renderPartial('/_sidebar/top', array('member' => null, 'titlePrefix' => 'Знаток'));?>
                </div>
                <?php /**
                if ('rating' !== Yii::app()->controller->id)
                $this->renderPartial('/_sidebar/rating', array());
                 **/ ?>
                <?php $this->renderPartial('/_sidebar/hot', array());?>
            </aside>

        </div>
    </div>
<?php $this->endContent(); ?>