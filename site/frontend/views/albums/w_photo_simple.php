<div id="photo-window-in">

    <div class="photo-bg">

        <div class="top-line clearfix">

            <a onclick="$.fancybox.close();" href="javascript:void(0);" class="close"></a>

            <div class="user">
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $photo->author,
                    'size' => 'small',
                    'sendButton' => false,
                    'location' => false
                )); ?>
            </div>

            <div class="photo-info photo-container">
                <?php $this->widget('FavouriteWidget', array('model' => $photo)); ?>

                <a id="gallery-top-link" href="#gallery-top" style="display:none !important;"></a>
                <?=$title?><?php if (get_class($model) != 'Contest'): ?> - <span class="count"><span><?=($currentIndex + 1)?></span> фото из <?=$count?></span><?php endif; ?>
                <div id="gallery-top" class="title"><?=$photo->w_title?></div>
            </div>

        </div>

        <script type="text/javascript">
            <?php ob_start(); ?>
            <?php foreach ($preload as $i => $p): ?>
            pGallery.photos[<?php echo $p->id ?>] = {
                idx : <?=(($p->w_idx !== null) ? $p->w_idx : $i) + 1?>,
                prev : <?=($i != 0) ? $photos[$i - 1]->id : 'null'?>,
                next : <?=($i < count($preload) - 1) ? $photos[$i + 1]->id : 'null'?>,
                src : '<?php echo $p->getPreviewUrl(960, 627, Image::HEIGHT); ?>',
                title : <?=($p->w_title === null) ? 'null' : '\'' . CJavaScript::quote($p->w_title) . '\''?>,
                description : <?=($p->w_description === null) ? 'null' : '\'' . CJavaScript::quote($p->w_description) . '\''?>,
                avatar : '<?php
                            $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                                'user' => $p->author,
                                'size' => 'small',
                                'sendButton' => false,
                                'location' => false
                            ));
                    ?>'
            };
            <?php endforeach; ?>
            <?php
                $ob = ob_get_clean();
                echo str_replace(array("\n", "\r"), '', $ob);
            ?>
            $.ajax({
                url : '/albums/postLoad/',
                data : {
                    entity : '<?=get_class($model)?>',
                    entity_id : '<?=($model->id !== null) ? $model->id : 'null'?>',
                    sort : '<?=Yii::app()->request->getQuery('sort', 'created')?>',
                    photo_id: '<?=$photo->id?>'
                },
                dataType : 'script'
            });
            pGallery.first = <?=$photos[0]->id?>;
            pGallery.last = <?=end($photos)->id?>;
            pGallery.start = <?=$photo->id?>;
        </script>

        <?php if (in_array(get_class($model), array('CommunityContentGallery', 'Contest'))): ?>
            <div class="content-cols clearfix">
                <div class="col-12 photo-banner-hold ">

                    <div id="photo" class="photo-container">

                        <div class="img">
                            <table><tr><td><?=CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT), '')?></td></tr></table>
                        </div>

                        <a href="javascript:void(0)" class="prev" onclick="dl = escape(document.location.href);pr = Math.floor(Math.random() * 1000000);AdFox_getCodeScript(1,pr1,'http://ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;dl='+dl+'&amp;pr1='+pr1)"><i class="icon"></i>предыдушая</a>
                        <a href="javascript:void(0)" class="next" onclick="dl = escape(document.location.href);pr = Math.floor(Math.random() * 1000000);AdFox_getCodeScript(1,pr1,'http://ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;dl='+dl+'&amp;pr1='+pr1)"><i class="icon"></i>следующая</a>

                    </div>

                </div>

                <div class="col-3">
                    <?php if (false): ?>
                    <div class="margin-t60" id="AdfoxAjax">
                        <!--AdFox START-->
                        <!--giraffe-->
                        <!--Площадка: Весёлый Жираф / * / *-->
                        <!--Тип баннера: Безразмерный 240x400-->
                        <!--Расположение: &lt;сайдбар&gt;-->
                        <!-- ________________________AdFox Asynchronous code START__________________________ -->
                        <script type="text/javascript">
                            <!--
                            if (typeof(pr) == 'undefined') { var pr = Math.floor(Math.random() * 1000000); }
                            if (typeof(document.referrer) != 'undefined') {
                                if (typeof(afReferrer) == 'undefined') {
                                    afReferrer = escape(document.referrer);
                                }
                            } else {
                                afReferrer = '';
                            }
                            var addate = new Date();


                            var dl = escape(document.location);
                            var pr1 = Math.floor(Math.random() * 1000000);

                            $('#AdfoxAjax').append('<div id="AdFox_banner_'+pr1+'"><\/div>');
                            $('#AdfoxAjax').append('<div style="visibility:hidden; position:absolute;"><iframe id="AdFox_iframe_'+pr1+'" width=1 height=1 marginwidth=0 marginheight=0 scrolling=no frameborder=0><\/iframe><\/div>');

                            AdFox_getCodeScript(1,pr1,'http://ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;dl='+dl+'&amp;pr1='+pr1);
                            // -->
                        </script>
                        <!-- _________________________AdFox Asynchronous code END___________________________ -->

                    </div>
                    <?php endif; ?>

                    <div class="margin-t60" id="yandex_ad_popup"></div>
                </div>
            </div>
        <?php else: ?>
            <div id="photo" class="photo-container">

                <div class="img">
                    <table><tr><td><?=CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT), '')?></td></tr></table>
                </div>

                <a href="javascript:void(0)" class="prev"><i class="icon"></i>предыдушая</a>
                <a href="javascript:void(0)" class="next"><i class="icon"></i>следующая</a>

            </div>
        <?php endif; ?>

        <div class="photo-comment photo-container"">
        <p><?=$photo->w_description?></p>
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

</div>