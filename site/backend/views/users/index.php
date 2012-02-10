<div id="users-groups-list">
    <p><?php echo CHtml::link('All', 'javascript:void(0)', array('rel' => 'all', 'rel2' => '')); ?></p>

    <p><?php echo CHtml::link('Mail', 'javascript:void(0)', array('rel' => 'gender', 'rel2' => 1)); ?></p>

    <p><?php echo CHtml::link('Femail', 'javascript:void(0)', array('rel' => 'gender', 'rel2' => 0)); ?></p>
</div>


<form method="get" action="" onsubmit="return changeUserView(this);" id="user-view-form">
    <input type="hidden" name="change_view" value="1"/>
    <input type="hidden" id="user-list-filter" name="" value=""/>
    <?php echo CHtml::dropDownList('list_type', '', array('table' => 'table', 'list1' => 'list 1', 'list2' => 'list 2'), array('onchange' => '$("#user-view-form").submit();')); ?>

    <div id="users-list">
        <?php $this->renderPartial('_' . $list_type, array(
        'dataProvider' => $dataProvider,
    )); ?>
    </div>
    <input type="checkbox" id="user-list-select-all" onchange="selectAllUsers(this)"; />
    <label for="user-list-select-all">Выделить все</label>&nbsp;&nbsp;
    С отмеченными: <?=CHtml::dropDownList('workWithItemsSelected', null, array('delete' => 'Удалить'),array('empty' =>'--')); ?>
    <?=CHtml::submitButton('Выполнить'); ?>
</form>
<script type="text/javascript">
    function changeUserView(form) {
        $('#user-list-select-all').removeAttr('checked');
        $.get(
            '<?php echo $this->createUrl('users/index'); ?>',
            $(form).serialize(),
            function (data) {
                $('#users-list').html(data);
            }
        );
        return false;
    }
    $('#users-groups-list a').click(function () {
        $('#user-list-filter').attr('name', $(this).attr('rel')).val($(this).attr('rel2'));
        $("#user-view-form").submit();
    });
    function selectAllUsers(input) {
        if($(input).is(':checked'))
            $('#user-list-grid input').attr('checked', 'checked');
        else
            $('#user-list-grid input').removeAttr('checked');
    }
</script>