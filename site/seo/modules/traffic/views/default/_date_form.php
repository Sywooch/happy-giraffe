<form action="/traffic/default/<?= Yii::app()->controller->action->id  ?>/">
    <div class="fast-filter">
        <?php if (!isset($user_id)):?>
            <?= CHtml::link('сегодня', $this->createUrl('index', array('last_date' => date("Y-m-d"), 'date' => date("Y-m-d"))), array('class' => ($period == 'today') ? 'active' : '')) ?>
            |
            <?= CHtml::link('вчера', $this->createUrl('index', array('last_date' => date("Y-m-d", strtotime('-1 day')), 'date' => date("Y-m-d", strtotime('-1 day')))), array('class' => ($period == 'yesterday') ? 'active' : '')) ?>
            |
            <?= CHtml::link('неделя', $this->createUrl('index', array('last_date' => date("Y-m-d"), 'date' => date("Y-m-d", strtotime('-6 days')))), array('class' => ($period == 'week') ? 'active' : '')) ?>
            |
            <?= CHtml::link('месяц', $this->createUrl('index', array('last_date' => date("Y-m-d"), 'date' => date("Y-m-d", strtotime('-1 month')))), array('class' => ($period == 'month') ? 'active' : '')) ?>
        <?php else: ?>
            <?= CHtml::link('сегодня', $this->createUrl('index', array('user_id'=>$user_id, 'last_date' => date("Y-m-d"), 'date' => date("Y-m-d"))), array('class' => ($period == 'today') ? 'active' : '')) ?>
            |
            <?= CHtml::link('вчера', $this->createUrl('index', array('user_id'=>$user_id, 'last_date' => date("Y-m-d", strtotime('-1 day')), 'date' => date("Y-m-d", strtotime('-1 day')))), array('class' => ($period == 'yesterday') ? 'active' : '')) ?>
            |
            <?= CHtml::link('неделя', $this->createUrl('index', array('user_id'=>$user_id, 'last_date' => date("Y-m-d"), 'date' => date("Y-m-d", strtotime('-6 days')))), array('class' => ($period == 'week') ? 'active' : '')) ?>
            |
            <?= CHtml::link('месяц', $this->createUrl('index', array('user_id'=>$user_id, 'last_date' => date("Y-m-d"), 'date' => date("Y-m-d", strtotime('-1 month')))), array('class' => ($period == 'month') ? 'active' : '')) ?>
        <?php endif ?>
            |
        <a href="javascript:;" class="pseudo<?= ($period == 'manual') ? ' active' : '' ?>"
           onclick="$(this).next().toggle();">Указать дату</a>

        <span <?= ($period == 'manual') ? '' : 'style="display: none;"' ?>>
            <?php if (isset($user_id)): ?>
            <?= CHtml::hiddenField('user_id', $user_id) ?>
            <?php endif ?>

            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'date',
            'value' => ($period == 'manual') ? $date : '',
            'language' => 'ru',
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'width' => '100px'
            )
        ));

            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'last_date',
                'value' => ($period == 'manual') ? $last_date : '',
                'language' => 'ru',
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array(
                    'width' => '100px'
                )
            )); ?>
            <button class="btn-green-small" onclick="$(this).parents('form').submit();">Ok</button>
    </span>
    </div>
</form>