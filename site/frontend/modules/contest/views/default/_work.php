<li>
    <div class="contest-ball clearfix">
        <div class="user-info clearfix">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $data->author,
                'size' => 'small',
                'small' => true,
            )); ?>
            <div class="details">
                <span class="icon-status status-<?php echo $data->author->online == 1 ? 'online' : 'offline'; ?>"></span>
                <?=HHtml::link(CHtml::encode($data->author->fullName), $data->author->url, array('class'=>'username'), true)?>
            </div>
            <div class="ball">
                <div class="ball-count"><?=$data->rate?></div>
                <div class="ball-text">баллов</div>
            </div>
        </div>
    </div>
    <div class="img">
        <a href="javascript:void(0)" data-id="<?=$data->photo->photo->id?>">
            <?=CHtml::image($data->photo->photo->getPreviewUrl(210, null, Image::WIDTH))?>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="item-title"><?=$data->title?></div>
</li>