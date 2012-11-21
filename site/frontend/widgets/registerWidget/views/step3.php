<div class="register-finish reg3 clearfix" style="display: none;">

    <div class="logo-box">
        <?=HHtml::link('', '/', array('class' => 'logo'), true)?>
    </div>

    <div class="green">Ура, вы с нами!</div>

    <div class="ava"<?php if (!isset($regdata['avatar'])) echo ' style="display:none;"' ?>>
        <?php if (isset($regdata['photo'])) echo CHtml::image($regdata['photo'], 'Это Вы') ?>
    </div>

    <div class="preparing"><?=$this->template[$type]['step3']['title1'] ?><span><span
            id="reg_timer">3</span> сек.</span></div>

</div>