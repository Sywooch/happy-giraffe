<?php $this->beginContent('//layouts/main'); ?>

<div class="section-banner">
    <div class="contest-text">
        <div class="holder">
            <img src="/images/contest/banner-mother-i-2.jpg" alt="" />
            <a href="" class="btn-blue btn-blue-55">Участвовать!</a>
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