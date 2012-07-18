<li>
    <div class="img">
        <a href="javascript:void(0)" data-id="<?=$data->photo->id?>">
            <img src="<?=$data->photo->getPreviewUrl(210, 600, Image::WIDTH, true, AlbumPhoto::CROP_SIDE_TOP);?>"/>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="user clearfix">
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
    <div class="item-title"><?=$data->photo->title;?></div>
</li>