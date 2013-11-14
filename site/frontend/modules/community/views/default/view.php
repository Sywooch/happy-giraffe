<?php
/**
 * @var User[] $users подписчики
 * @var int $user_count кол-во подписчиков
 * @var CommunityContent $content кол-во подписчиков
 */

$this->renderPartial('blog.views.default.view', array('full' => true, 'data' => $content));
?>

<?php if (($newUser = Yii::app()->user->getState('newUser')) !== null): ?>
<script type="text/javascript">
    Register.showStep2(<?=CJavaScript::encode($newUser['email'])?>, 'default', <?=CJSON::encode($newUser)?>);
</script>
<?php endif; ?>