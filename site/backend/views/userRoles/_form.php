<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'role'); ?>
        <?php echo CHtml::dropDownList('User[role]', $model->getRole(), CHtml::listData(Yii::app()->authManager->getRoles(), 'name', 'name'), array('empty' => ' ')); ?>
        <?php echo $form->error($model, 'role'); ?>
    </div>

    <div class="row">
        <label>Сообщество</label>
        <?php echo CHtml::dropDownList('community_id', '', CHtml::listData(Community::model()->findAll(), 'id', 'title'), array('empty' => 'Все')); ?>
    </div>

    <b>Действия</b><br>

    <?php $am = Yii::app()->authManager; ?>
    <?php $items = $am->getOperations(); ?>

    <div class="r-list">
        <?php echo CHtml::checkBox('check-all-oper', false, array('class' => 'check-all-oper')) ?> отметить все <br><br>
        <?php if ($model->getRole() != 'moderator'): ?>
        <?php foreach ($items as $item): ?>
            <?php echo CHtml::checkBox('Operation[' . $item->name . ']', $am->isAssigned($item->name, $model->id)) ?>
            <?php echo CHtml::label($item->description, 'Operation_' . $item->name, array('style' => 'display:inline')) ?>
            <br>
            <?php endforeach; ?>
        <?php else: ?>
        <input type="checkbox" id="Operation_createClubPost" name="Operation[createClubPost]" value="1"<?php if ($am->isAssigned('createClubPost', $model->id)) echo ' checked'; ?>>
        <label for="Operation_createClubPost" style="display:inline">Создание постов в сообществах</label>        <br>
        <input type="checkbox" id="Operation_editComment" name="Operation[editComment]" value="1"<?php if ($am->isAssigned('editComment', $model->id)) echo ' checked'; ?>>
        <label for="Operation_editComment" style="display:inline">редактирование комментариев</label>        <br>
        <input type="checkbox" id="Operation_editCommunityContent" name="Operation[editCommunityContent]" value="1"<?php if ($am->isAssigned('editCommunityContent', $model->id)) echo ' checked'; ?>>
        <label for="Operation_editCommunityContent" style="display:inline">редактирование тем в сообществах (название
            темы, текст)</label>        <br>
        <input type="checkbox" id="Operation_editCommunityRubric" name="Operation[editCommunityRubric]" value="1"<?php if ($am->isAssigned('editCommunityRubric', $model->id)) echo ' checked'; ?>>
        <label for="Operation_editCommunityRubric" style="display:inline">изменение рубрик в темах</label>        <br>
        <input type="checkbox" id="Operation_editUser" name="Operation[editUser]" value="1"<?php if ($am->isAssigned('editUser', $model->id)) echo ' checked'; ?>>
        <label for="Operation_editUser" style="display:inline">полное редактирование страницы пользователей</label>
        <br>
        <input type="checkbox" id="Operation_removeComment" name="Operation[removeComment]" value="1"<?php if ($am->isAssigned('removeComment', $model->id)) echo ' checked'; ?>>
        <label for="Operation_removeComment" style="display:inline">удаление комментариев</label>        <br>
        <input type="checkbox" id="Operation_removeCommunityContent" name="Operation[removeCommunityContent]" value="1"<?php if ($am->isAssigned('removeCommunityContent', $model->id)) echo ' checked'; ?>>
        <label for="Operation_removeCommunityContent" style="display:inline">Удаление тем в сообществах</label>
        <br>
        <input type="checkbox" id="Operation_transfer post" name="Operation[transfer post]" value="1"<?php if ($am->isAssigned('transfer post', $model->id)) echo ' checked'; ?>>
        <label for="Operation_transfer post" style="display:inline">перенос темы из сообщества в сообщество</label>
        <br>
        <?php endif ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

    <div id="moder-rights" style="display: none;">
        <input type="checkbox" class="check-all-oper" name="check-all-oper" value="1"> отметить все <br><br>
        <input type="checkbox" id="Operation_createClubPost" name="Operation[createClubPost]" value="1">
        <label for="Operation_createClubPost" style="display:inline">Создание постов в сообществах</label> <br>
        <input type="checkbox" id="Operation_editComment" name="Operation[editComment]" value="1">
        <label for="Operation_editComment" style="display:inline">редактирование комментариев</label> <br>
        <input type="checkbox" id="Operation_editCommunityContent" name="Operation[editCommunityContent]" value="1">
        <label for="Operation_editCommunityContent" style="display:inline">редактирование тем в сообществах (название
            темы, текст)</label> <br>
        <input type="checkbox" id="Operation_editCommunityRubric" name="Operation[editCommunityRubric]" value="1">
        <label for="Operation_editCommunityRubric" style="display:inline">изменение рубрик в темах</label> <br>
        <input type="checkbox" id="Operation_editUser" name="Operation[editUser]" value="1">
        <label for="Operation_editUser" style="display:inline">полное редактирование страницы пользователей</label> <br>
        <input type="checkbox" id="Operation_removeComment" name="Operation[removeComment]" value="1">
        <label for="Operation_removeComment" style="display:inline">удаление комментариев</label> <br>
        <input type="checkbox" id="Operation_removeCommunityContent" name="Operation[removeCommunityContent]" value="1">
        <label for="Operation_removeCommunityContent" style="display:inline">Удаление тем в сообществах</label> <br>
        <input type="checkbox" id="Operation_transfer post" name="Operation[transfer post]" value="1">
        <label for="Operation_transfer post" style="display:inline">перенос темы из сообщества в сообщество</label> <br>
    </div>

    <div id="all-rights" style="display: none;">
        <?php echo CHtml::checkBox('check-all-oper', false, array('class' => 'check-all-oper')) ?> отметить все <br><br>
        <?php $am = Yii::app()->authManager;  ?>
        <?php $items = $am->getOperations(); ?>
        <?php foreach ($items as $item): ?>
        <?php echo CHtml::checkBox('Operation[' . $item->name . ']', $am->isAssigned($item->name, $model->id)) ?>
        <?php echo CHtml::label($item->description, 'Operation_' . $item->name, array('style' => 'display:inline')) ?>
        <br>
        <?php endforeach; ?>
    </div>

</div><!-- form -->
<script type="text/javascript">
    $('body').delegate('.check-all-oper', 'click', function () {
        if ($(this).is(':checked'))
            $(this).parent().find('input[type=checkbox]').attr('checked', true);
        else
            $(this).parent().find('input[type=checkbox]').attr('checked', false);
    });

    $('#User_role').change(function () {
        if ($(this).val() == 'moderator')
            $('.r-list').html($('#moder-rights').html());
        else
            $('.r-list').html($('#all-rights').html());
    });
</script>