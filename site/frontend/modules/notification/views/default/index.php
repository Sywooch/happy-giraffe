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
        },
        readAll:function(){
            $.post('/notifications/readAll/', function (response) {
                if (response.status) {

                }
            }, 'json');
        }
    }
</script>
    <a href="javascript:;" onclick="UserNotification.readAll();">read All</a>
<?php
foreach ($list as $model)
    $this->renderPartial('types/type_' . $model->type, compact('model'));
