<script type="text/javascript">
    userIsGuest = 0;
</script>

<div class="b-registration">
    <div class="b-registration_row clearfix">
        <div class="float-r">
            <a href="<?=$this->createUrl('/family/default/signup')?>" class="b-registration_skip">Пропустить этот шаг</a>
            <a href="<?=$this->createUrl('/family/default/signup')?>" class="btn-green btn-h46">Готово, продолжить</a>
        </div>
        <div class="b-registration_t"><?=$this->user->first_name?>, выберите клубы</div>
    </div>

    <div class="content-cols">
        <div class="col-white padding-20">
            <div class="margin-20">
                <span class="i-highlight i-highlight__big font-big">Веселый Жираф вам рекомендует</span>
            </div>
            <?php $this->widget('application.modules.profile.widgets.ClubsWidget', array('size' => 'Big', 'signup' => true, 'limit' => 10, 'all' => true, 'user' => $this->user)); ?>
            <div class="margin-20">
                <span class="i-highlight i-highlight__big font-big">Еще вам могут быть интересны</span>
            </div>
            <?php $this->widget('application.modules.profile.widgets.ClubsWidget', array('size' => 'Big', 'signup' => true, 'limit' => 10, 'offset' => 10, 'all' => true, 'user' => $this->user)); ?>
        </div>
    </div>

    <div class="b-registration_row clearfix">
        <div class="float-r">
            <a href="<?=$this->createUrl('/family/default/signup')?>" class="b-registration_skip">Пропустить этот шаг</a>
            <a href="<?=$this->createUrl('/family/default/signup')?>" class="btn-green btn-h46">Готово, продолжить</a>
        </div>
    </div>
</div>