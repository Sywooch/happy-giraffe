<?php
    Yii::import('application.modules.cook.models.*');
    $comment = Comment::model()->findByPk($action->data['id']);
    if ($comment !== null) {
        $model = CActiveRecord::model($comment->entity)->findByPk($comment->entity_id);
        $modelName = get_class($model);
    }
?>

<?php if ($comment !== null && in_array($modelName, array('BlogContent', 'CommunityContent', 'CookRecipe', 'AlbumPhoto'))): ?>
    <div class="user-post list-item">
        <?=$this->renderPartial('activity/_activity_friend', array('user_id' => $action['user_id'], 'type' => $type))?>

        <div class="box-title"><?=($users[$action->user_id]->gender == 1) ? 'Оставил' : 'Оставила'?> комментарий</div>

        <ul>
            <li>
                <?php if ($modelName == 'BlogContent'): ?>
                    <div class="added-to">
                    <?php if ($model->author_id == $action['user_id']): ?>
                        <span>в своем блоге</span>
                    <?php else: ?>
                        <span>в блоге</span>
                        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                            'user' => $model->author,
                            'size' => 'small',
                            'sendButton' => false,
                            'location' => false
                        )); ?>
                    <?php endif; ?>
                    </div>
                    <div class="item-title"><?=CHtml::link($model->title, $model->url)?></div>
                <?php elseif ($modelName == 'CommunityContent'): ?>
                    <div class="added-to">
                        <span>в клубе</span> <span><a href="<?=$model->rubric->community->url?>" class="club-img home small inline"><img src="/images/club_img_<?=$model->rubric->community->position?>.png" /><?=$model->rubric->community->title?></a></span>
                    </div>
                    <div class="item-title"><?=CHtml::link($model->title, $model->url)?></div>
                <?php elseif ($modelName == 'CookRecipe'): ?>
                    <div class="added-to">
                        <span>к кулинарному рецепту</span>
                    </div>
                    <div class="item-title"><?=CHtml::link($model->title, $model->url)?></div>
                <?php elseif ($modelName == 'AlbumPhoto'): ?>
                    <div class="added-to">
                        <span>к фото</span>
                    </div>
                    <div class="img"><?=CHtml::link(CHtml::image($model->getPreviewUrl(303, null, Image::WIDTH)), $model->getUrl())?></div>
                <?php endif; ?>
                <div class="comment">
                    <div class="date"><?=Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $comment->created)?></div>
                    <?=Str::truncate(strip_tags($comment->text))?> <?php if ($comment->url !== false): ?><?=CHtml::link('Читать', $comment->url)?><?php endif; ?>
                </div>
            </li>
        </ul>

    </div>
<?php endif; ?>