<div id="photo-window-in" class="photo-window-banner">

    <div class="photo-bg" >

        <a onclick="$.fancybox.close();" href="javascript:void(0);" class="close"></a>

        <div class="content-cols clearfix photo-container">
            <div class="col-12">

                <div class="top-line clearfix">


                    <div class="user">
                        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                            'user' => $photo->author,
                            'size' => 'small',
                            'sendButton' => false,
                            'location' => false
                        )); ?>
                    </div>
                    <?php $this->widget('FavouriteWidget', array('model' => $photo)); ?>
                    <div class="photo-info">
                        <a id="gallery-top-link" href="#gallery-top" style="display:none !important;"></a>
                        <?=$title?><?php if (get_class($model) != 'Contest'): ?> - <span class="count"><span><?=($currentIndex + 1)?></span> фото из <?=$count?></span><?php endif; ?>
                        <div class="title"><?=$photo->w_title?></div>
                    </div>

                </div>

                <div id="photo">

                    <div class="img">
                        <table><tr><td>
                                    <?=CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT), '')?>
                                </td></tr></table>
                    </div>

                    <a href="javascript:void(0)" class="prev" onclick="rtb_refresh()"><i class="icon"></i>предыдушая</a>
                    <a href="javascript:void(0)" class="next" onclick="rtb_refresh()"><i class="icon"></i>следующая</a>

                </div>

                <div class="photo-comment">
                    <p><?=$photo->w_description?></p>
                </div>

            </div>

            <div class="col-3">
                <div class="margin-t145" id="AdfoxAjax">
                    <iframe id="direct" src="http://www.happy-giraffe.ru/rtb2.html" width="200" height="300" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>
                </div>
            </div>
        </div>

        <div class="rewatch-container" style="display: none;"><?php
            if ($photo->galleryItem)
                $this->renderPartial('w_photo_last_post_gallery_page', compact('model', 'photo'));
            elseif (empty($photo->album->type) || $photo->album->type == Album::TYPE_PRIVATE || $photo->album->type == Album::TYPE_FAMILY)
                $this->renderPartial('w_photo_last_album_page', compact('more', 'count', 'title'));
            ?></div>

    </div>

    <div id="w-photo-content" class="photo-container">
        <?php $this->renderPartial('w_photo_content', compact('model', 'photo')); ?>
    </div>

    <script type="text/javascript">
        function rtb_refresh() {
            var r = Math.floor(Math.random() * 1000000) + 1;
            var url = 'http://www.happy-giraffe.ru/rtb2.html?r=' + r;
            $('#direct').attr('src', url);
        }
    </script>

</div>