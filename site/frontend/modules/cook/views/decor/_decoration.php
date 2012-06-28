<li class="dish">
    <div class="clearfix">
        <div class="user-info clearfix">
            <?php
            $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $data->photo->author,
                'size' => 'small',
                'location' => false,
                'sendButton' => false
            ));
            ?>
        </div>
    </div>
    <div class="img">
        <a href="javascript:;" data-id="<?= $data->photo->id ?>"><img src="<?=$data->photo->getPreviewUrl(240, 160, Image::WIDTH, true, AlbumPhoto::CROP_SIDE_TOP);?>"/></a>
        <a href="javascript:;" data-id="<?= $data->photo->id ?>" class="btn-look">Посмотреть</a>
    </div>
    <div class="item-title"><?=$data->photo->title;?></div>
</li>