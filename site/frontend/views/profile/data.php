<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'profile-form'
));
?>
<div class="profile-form-in">

    <?php echo $form->errorSummary($this->user); ?>

    <div class="row row-inline clearfix">

        <div class="row-title">Персональные данные:</div>
        <div class="row-elements">
            <div class="col">
                <?php echo $form->textField($this->user, 'last_name', array(
                'placeholder' => 'Фамилия',
            )); ?>
            </div>
            <div class="col">
                <?php echo $form->textField($this->user, 'first_name', array(
                'placeholder' => 'Имя',
            )); ?>
            </div>

        </div>

    </div>

    <div class="row row-inline clearfix">

        <div class="row-title">Дата рождения:</div>
        <div class="row-elements">
            <div class="col">
                <div class="select-box">
                    <?php
                    $this->widget('DateWidget', array(
                        'model' => $this->user,
                        'attribute' => 'birthday',
                    ));
                    ?>
                </div>
            </div>
            <?php if ($this->user->birthday): ?>
            <div class="col age">
                Возраст: <b><?php echo $this->user->age; ?></b> <?php echo $this->user->ageSuffix; ?>
            </div>
            <?php endif; ?>

        </div>

    </div>

    <div class="row row-inline clearfix">

        <div class="row-title">Пол:</div>
        <div class="row-elements">
            <div class="col">
                <label><?php echo $form->radioButton($this->user, 'gender', array('value' => 0)); ?> Женщина</label>

            </div>
            <div class="col">
                <label><?php echo $form->radioButton($this->user, 'gender', array('value' => 1)); ?> Мужчина</label>
            </div>

        </div>

    </div>


<div class="row row-inline clearfix">

    <div class="row-title">E-mail:</div>
    <div class="row-elements">
        <div class="col">
            <?php echo $form->textField($this->user, 'email', array('placeholder' => 'Ваш e-mail')); ?>
            <div class="row-bottom">Укажите реальный и действующий e-mail адрес.</div>
        </div>
    </div>

</div>

<div class="row row-inline clearfix">

    <div class="row-title">Участник с:</div>
    <div class="row-elements">
        <div class="text small">
            <?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy", $this->user->register_date); ?>
        </div>
    </div>

</div>

<div class="row row-inline clearfix">
    <div class="row-title">Удалить анкету:</div>
    <div class="row-elements">
        <div class="text">Да, я
            хочу <?php echo CHtml::link('Удалить анкету', array('remove'), array('class' => 'remove', 'confirm' => 'Вы действительно хотите удалить анкету?')) ?>
            , потеряв всю введенную информацию без возможности восстановления.
        </div>
    </div>
</div>

<div class="bottom">
    <button class="btn btn-green-medium btn-arrow-right">
        <span><span>Сохранить<img src="/images/arrow_r.png"/></span></span>
    </button>
</div>

<?php $this->endWidget(); ?>
</div>