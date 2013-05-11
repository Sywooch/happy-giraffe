<?php
/**
 * @var $list Notification[] список уведомлений для вывода
 */
?>
<script type="text/javascript">
    var UserNotification = {
        read: function (el, id) {
            $.post('/notifications/read/', {id: id}, function (response) {
                if (response.status) {
                    el.parent().remove();
                }
            }, 'json');
        }
    }
</script>
<?php
foreach ($list as $model)
    $this->renderPartial('types/type_' . $model->type, compact('model'));
