<?php $this->beginContent('//layouts/main'); ?>

<?php
    $cs = Yii::app()->clientScript;

    $cs
        ->registerScriptFile('/javascripts/jquery.tmpl.min.js')
        ->registerScriptFile('http://vk.com/js/api/share.js?11')
        ->registerCssFile('http://stg.odnoklassniki.ru/share/odkl_share.css')
        ->registerScriptFile('http://stg.odnoklassniki.ru/share/odkl_share.js')
    ;
?>

<div id="contest" class="contest-<?=$this->contest->id?>">

    <div class="section-banner">
        <?php if (in_array($this->contest->getCanParticipate(), array(Contest::STATEMENT_GUEST, Contest::STATEMENT_STEPS, true), true)): ?>
        <div class="button-holder">
            <a href="<?=$this->createUrl('/contest/default/statement', array('id' => $this->contest->id))?>" onclick="Contest.canParticipate(this, '<?=$this->createUrl('/contest/default/canParticipate', array('id' => $this->contest->id))?>'); return false;" class="contest-button">Участвовать!</a>
        </div>
        <?php endif; ?>
        <img src="/images/contest/banner-w1000-<?=$this->contest->id?>.jpg">
    </div>

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
                        'label' => 'Призы',
                        'url' => array('/contest/default/prizes', 'id' => $this->contest->id),
                        'active' => $this->action->id == 'prizes',
                        'visible' => $this->contest->id >= 4,
                    ),
                    array(
                        'label' => 'Участники',
                        'url' => array('/contest/default/list', 'id' => $this->contest->id),
                        'active' => $this->action->id == 'list',
                    ),
                    array(
                        'label' => 'Победители',
                        'url' => array('/contest/default/results', 'id' => $this->contest->id),
                        'active' => $this->action->id == 'results',
                        'visible' => $this->contest->status == Contest::STATUS_RESULTS,
                    ),
                ),
            ));
        ?>
    </div>

    <?php if ($this->contest->id == 9): ?>
        <div class="contest-sponsor">
            <img src="/images/contest/contest-sponsor.jpg" alt="" class="contest-sponsor_img">

            <?php if (in_array($this->contest->getCanParticipate(), array(Contest::STATEMENT_GUEST, Contest::STATEMENT_STEPS, true), true)): ?>
                <div class="button-holder">
                    <a href="<?=$this->createUrl('/contest/default/statement', array('id' => $this->contest->id))?>" class="contest-button" onclick="Contest.canParticipate(this, '<?=$this->createUrl('/contest/default/canParticipate', array('id' => $this->contest->id))?>'); return false;">Принять участие</a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?=$content?>

</div>

<?php $this->endContent(); ?>

<script id="oopsTmpl" type="text/x-jquery-tmpl">
    <div class="contest-error-hint">
        <h4>Oops!</h4><p>Чтобы принять участие в конкурсе, вам нужно пройти <a href="<?=urldecode($this->createUrl('/user/profile', array('user_id' => '${id}')))?>">первые 6 шагов</a> в свой анкете </p>
    </div>
</script>