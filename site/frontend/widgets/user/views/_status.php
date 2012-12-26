<div class="date"><?php if ($canUpdate): ?><a href="" class="a-right pseudo updateStatus">Новый статус</a><?php endif; ?><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $status->created); ?></div>
<p><?php echo $status->purified->text; ?></p>
<?php $model = $status->post->getContent() ?>
<div class="clearfix">
    <div class="meta">
        <div class="comments">
            <?php if ($model->getUnknownClassCommentsCount() > 0): ?>
            <?=CHtml::link('', $model->getUrl(true), array('class'=>'icon tooltip'))?>
            <?php $lastComments = $model->lastCommentators;
            foreach ($lastComments as $lc): ?>
                <?php
                $class = 'ava small';
                if ($lc->author->gender !== null) $class .= ' ' . (($lc->author->gender) ? 'male' : 'female');
                ?>
                <?=HHtml::link(CHtml::image($lc->author->getAva('small')), ($lc->author->deleted)?'#':$lc->author->url, array('class' => $class), true)?>
                <?php endforeach; ?>
            <?php if ($model->getUnknownClassCommentsCount() > count($lastComments)): ?>
                <?=CHtml::link('и еще ' . ($model->getUnknownClassCommentsCount() - count($lastComments)), $model->getUrl(true))?>
                <?php endif; ?>
            <?php else: ?>
                <?=CHtml::link('', $model->getUrl(true), array('class'=>'icon icon-plus tooltip'))?>
            <?php endif; ?>
        </div>
    </div>
</div>