<?php
    $content = CommunityContent::model()->findByPk($action->data['id']);
?>

<?php if ($content !== null): ?>
    <div class="user-post list-item">
        <?=$this->renderPartial('activity/_activity_friend', array('user_id' => $action['user_id'], 'type' => $type))?>

        <div class="box-title"><?=($users[$action->user_id]->gender == 1) ? 'Добавил' : 'Добавила'?> запись</div>

        <ul>
            <li>
                <div class="added-to">
                    <span>в клубе</span> <span><a href="<?=$content->rubric->community->url?>" class="club-img kids small inline"><img src="/images/club_img_<?=$content->rubric->community->position ?>.png" /><span><?=$content->rubric->community->title?></span></a></span>
                </div>
                <div class="item-title"><?=CHtml::link($content->title, $content->url)?></div>
                <div class="added-date"><?=Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $content->created)?></div>
                <?php if (($image = $content->contentImage) !== false): ?>
                    <div class="img">
                        <?=CHtml::link(CHtml::image($image), $content->url)?>
                    </div>
                <?php endif; ?>
                <div class="content">
                    <p><?=$content->contentText?> <?=CHtml::link('Читать всю запись<i class="icon"></i>', $content->url, array('class' => 'read-more'))?></p>
                </div>
                <div class="meta">
                    <span class="views"><i class="icon"></i><?=PageView::model()->viewsByPath($content->url)?></span>
                    <?=CHtml::link('<i class="icon"></i>' . $content->commentsCount, $content->getUrl(true), array('class' => 'comments'))?>
                </div>
            </li>

        </ul>

    </div>
<?php endif; ?>