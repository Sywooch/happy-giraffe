<?php
/* @var $this Controller
 * @var $c CommunityContent
 */
if (!Yii::app()->user->isGuest && ($c->canEdit() || $c->canRemove())): ?>
<div class="admin-actions">

    <?php if ($c->canEdit()): ?>
        <?php
            if ($c->isFromBlog) {
                $edit_url = $this->createUrl('/blog/edit', array('content_id' => $c->id));
            } else {
                $edit_url = $this->createUrl('/community/edit', array('content_id' => $c->id));
            }
        ?>

        <?php echo CHtml::link('<i class="icon"></i>', $edit_url, array('class' => 'edit')); ?>
    <?php endif; ?>

    <?php if (!$c->isFromBlog && Yii::app()->user->model->checkAuthItem('transfer post')): ?>
    <input type="hidden" value="<?php echo $c->id ?>">
    <a href="#movePost" class="move fancy">Переместить</a>
    <?php endif; ?>

    <?php if ($c->canRemove()): ?>
        <?php $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
            'model' => $c,
            'callback' => 'CommunityContentRemove',
            'author' => !Yii::app()->user->isGuest && Yii::app()->user->id == $c->author_id
        ));
        if ($c->isFromBlog) {
            $delete_redirect_url = $this->createUrl('/blog/list', array('user_id' => $c->author_id));
        } else {
            $delete_redirect_url = $this->createUrl('community/list', array(
                'community_id' => $c->rubric->community->id,
                'content_type_slug' => $c->type->slug));
        }

        Yii::app()->clientScript->registerScript('register_after_removeContent', '
            function CommunityContentRemove() {window.location = "' . $delete_redirect_url . '";}', CClientScript::POS_HEAD);
        ?>
    <?php endif; ?>
</div>
<?php endif; ?>