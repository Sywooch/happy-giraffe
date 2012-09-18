<li class="clearfix">
    <div class="actions">
        <a href="" class="btn-green small">Перейти</a>
        <a href="" class="skip">Я знаю</a>
    </div>
    <div class="content">
        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => User::model()->findByPk($data->initiator_id),
            'small' => true,
            'size' => 'small',
        )); ?>
        <div class="in">
            <?=$data->text?>
            <div class="meta">
                <span class="date">Сегодня  13:25</span>
            </div>
        </div>
    </div>
</li>