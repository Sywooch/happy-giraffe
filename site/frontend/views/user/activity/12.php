<?php
    $comment = Comment::model()->findByPk($action->data['id']);
    $model = CActiveRecord::model($comment->entity)->findByPk($comment->entity_id);
    $modelName = get_class($model);
?>

<?php if ($comment !== null && in_array($modelName, array('BlogContent', 'CommunityContent', 'CookRecipe', 'AlbumPhoto'))): ?>
    <div class="user-post list-item">

        <div class="box-title">Оставил комментарии</div>

        <ul>
            <li>
                <?php if ($modelName == 'BlogContent'): ?>
                    <div class="added-to">
                        <span>в блоге</span>
                        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                            'user' => $content->author,
                            'size' => 'small',
                            'sendButton' => false,
                            'location' => false
                        )); ?>
                    </div>
                    <div class="item-title"><?=CHtml::link($model->title, $model->url)?></div>
                <?php elseif ($modelName == 'CommunityContent'): ?>
                    <div class="added-to">
                        <span>в клубе</span> <a href="<?=$model->rubric->community->url?>" class="club-img home small inline"><img src="/images/club_img_<?=$model->rubric->community->id?>.png" /><?=$model->rubric->community->title?></a>
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
                    <div class="img"><?=CHtml::image($model->getPreviewUrl(303, null, Image::WIDTH))?></div>
                <?php endif; ?>
                <?php endif; ?>
                <div class="comment">
                    <div class="date"><?=Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $comment->created)?></div>
                    <?=Str::truncate(strip_tags($comment->text)?> <?=CHtml::link('Читать', $comment->url)?>
                </div>
            </li>
        </ul>

    </div>
<?php endif; ?>