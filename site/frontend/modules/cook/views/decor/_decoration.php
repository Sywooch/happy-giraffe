<li>
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
    <div class="img">
        <a href="javascript:void(0)" data-id="<?=$data->photo->id?>">
            <?=HHtml::lazyImage($data->photo->getPreviewUrl(210, 600, Image::WIDTH, true, AlbumPhoto::CROP_SIDE_TOP), $data->photo->width, $data->photo->height)?>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="item-title"><?=$data->title?></div>
</li>