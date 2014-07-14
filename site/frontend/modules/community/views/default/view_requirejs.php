<?php
/**
 * @var User[] $users подписчики
 * @var int $user_count кол-во подписчиков
 * @var CommunityContent $content кол-во подписчиков
 */
Yii::app()->clientScript->useAMD = true;

$this->renderPartial('blog.views.default.view_requirejs', array('full' => true, 'data' => $content));
?>

<?php if (($newUser = Yii::app()->user->getState('newUser')) !== null): ?>
<script type="text/javascript">
    Register.showStep2(<?=CJavaScript::encode($newUser['email'])?>, 'default', <?=CJSON::encode($newUser)?>);
</script>
<?php endif; ?>