<?php $this->beginContent('//layouts/main'); ?>

<?php
    $cs = Yii::app()->clientScript;

    $cs
        ->registerScriptFile('/javascripts/jquery.tmpl.min.js')
    ;
?>

<div class="section-banner">
    <div class="contest-text">
        <div class="holder">
            <img src="/images/contest/banner-mother-i-2.jpg" alt="<?=$this->contest->title?>" />
            <?php if (Yii::app()->user->isGuest || Yii::app()->user->model->getContestWork($this->contest->id) === null): ?>
                <div class="button-holder">
                    <a href="<?=$this->createUrl('/contest/default/statement', array('id' => $this->contest->id))?>" onclick="Contest.canParticipate(this, '<?=$this->createUrl('/contest/default/canParticipate', array('id' => $this->contest->id))?>'); return false;" class="btn-blue btn-blue-55">Участвовать!</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <img src="/images/contest/banner-mother-i-1.jpg" />
</div>

<div id="contest">

    <div class="contest-nav clearfix">
        <?php
            $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array(
                        'label' => 'О конкурсе',
                        'url' => array('/contest/default/view', 'id' => $this->contest->id),
                        'active' => $this->action->id == 'view',
                    ),
                    array(
                        'label' => 'Правила',
                        'url' => array('/contest/default/rules', 'id' => $this->contest->id),
                        'active' => $this->action->id == 'rules',
                    ),
                    array(
                        'label' => 'Участники',
                        'url' => array('/contest/default/list', 'id' => $this->contest->id),
                        'active' => $this->action->id == 'list',
                    ),
                ),
            ));
        ?>
    </div>

    <?=$content?>

</div>

<?php $this->endContent(); ?>

<script id="oopsTmpl" type="text/x-jquery-tmpl">
    <div class="contest-error-hint">
        <h4>Oops!</h4><p>Что бы принять участие в конкурсе, вам нужно пройти <a href="<?=urldecode($this->createUrl('/user/profile', array('user_id' => '${id}')))?>">первые 6 шагов</a> в свой анкете </p>
    </div>
</script>