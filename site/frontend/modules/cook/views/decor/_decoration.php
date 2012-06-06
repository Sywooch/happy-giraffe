<li class="dish">
    <div class="clearfix">
        <div class="user-info clearfix">
            <?php
            $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $data->photo->author,
                'size' => 'small',
                'location' => false
            ));
            ?>
        </div>
    </div>
    <div class="img">
        <a href=""><img src="<?=$data->photo->getPreviewUrl(240, 160, Image::NONE);?>"/></a>
        <a href="" class="btn-look">Посмотреть</a>
    </div>
    <div class="item-title"><?=$data->title;?></div>
</li>