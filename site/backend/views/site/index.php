<?php if (Yii::app()->user->checkAccess('administrator')):?>
    <?= CHtml::ajaxLink('регистрации', '/stats/registers/', array('update'=>'#result')) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?= CHtml::ajaxLink('контент', '/stats/entities/', array('update'=>'#result')) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?= CHtml::ajaxLink('конкурс', '/stats/likes/', array('update'=>'#result')) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?= CHtml::ajaxLink('регионы', '/stats/regions/', array('update'=>'#result')) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?= CHtml::ajaxLink('интересы', '/stats/interests/', array('update'=>'#result')) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?= CHtml::ajaxLink('сотрудники', '/stats/workers/', array('update'=>'#result')) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?= CHtml::ajaxLink('пользователи', '/stats/users/', array('update'=>'#result')) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?= CHtml::ajaxLink('уникальность', '/stats/uniqueness/', array('update'=>'#result')) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php endif ?><br><br>
<div id="result">

</div>