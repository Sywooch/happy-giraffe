<script type="text/javascript">
    Share = {
        vkontakte: function(purl, ptitle, pimg, text) {
            url  = 'http://vkontakte.ru/share.php?';
            url += 'url='          + encodeURIComponent(purl);
            url += '&title='       + encodeURIComponent(ptitle);
            url += '&description=' + encodeURIComponent(text);
            url += '&image='       + encodeURIComponent(pimg);
            url += '&noparse=true';
            Share.popup(url);
        },
        odnoklassniki: function(purl, text) {
            url  = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1';
            url += '&st.comments=' + encodeURIComponent(text);
            url += '&st._surl='    + encodeURIComponent(purl);
            Share.popup(url);
        },
        facebook: function(purl, ptitle, pimg, text) {
            url  = 'http://www.facebook.com/sharer.php?s=100';
            url += '&p[title]='     + encodeURIComponent(ptitle);
            url += '&p[summary]='   + encodeURIComponent(text);
            url += '&p[url]='       + encodeURIComponent(purl);
            url += '&p[images][0]=' + encodeURIComponent(pimg);
            Share.popup(url);
        },
        twitter: function(purl, ptitle) {
            url  = 'http://twitter.com/share?';
            url += 'text='      + encodeURIComponent(ptitle);
            url += '&url='      + encodeURIComponent(purl);
            url += '&counturl=' + encodeURIComponent(purl);
            Share.popup(url);
        },
        mailru: function(purl, ptitle, pimg, text) {
            url  = 'http://connect.mail.ru/share?';
            url += 'url='          + encodeURIComponent(purl);
            url += '&title='       + encodeURIComponent(ptitle);
            url += '&description=' + encodeURIComponent(text);
            url += '&imageurl='    + encodeURIComponent(pimg);
            Share.popup(url)
        },

        popup: function(url) {
            window.open(url,'','toolbar=0,status=0,width=626,height=436');
        }
    };
</script>

<div class="photo-view">
    <div class="user-info">
        <a href="" class="ava-small"></a>
        <div class="user-info_details margin-b10">
            <div class="user-info_time float-r"><?=HDate::GetFormattedTime($photo->created, ', ')?></div>
            <?=CHtml::link($photo->author->fullName, array('user/index', 'user_id' => $photo->author_id, 'show' => 'all'), array('class' => 'user-info_name textdec-onhover'))?>
        </div>
    </div>
    <div class="textalign-c margin-b10">
        <div class="text-small color-gray">Фотоконкурс "<?=$model->title?>"</div>
        <?php if ($photo->w_title): ?>
            <div class="color-blue"><strong><?=$photo->w_title?></strong></div>
        <?php endif; ?>
    </div>
    <div class="photo-view_img textalign-c margin-b10">
        <?=CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT, true), $photo->w_title)?>
    </div>
</div>
<div class="custom-likes-small margin-b10 clearfix">
    <a class="custom-like-small" href="javascript:void(0)" onclick="Share.odnoklassniki('<?=Yii::app()->request->hostInfo . Yii::app()->request->url?>', '')">
        <span class="custom-like-small_icon odkl"></span>
        <span class="custom-like-small_value"><?=Rating::model()->countByEntity($photo->getAttachByEntity('ContestWork')->model, 'ok')?></span>
    </a>
    <a class="custom-like-small" href="javascript:void(0)" onclick="Share.mailru('<?=Yii::app()->request->hostInfo . Yii::app()->request->url?>', '<?=$photo->w_title?>', '<?=$photo->getPreviewUrl(960, 627, Image::HEIGHT, true)?>', '')">
        <span class="custom-like-small_icon mailru"></span>
        <span class="custom-like-small_value"><?=Rating::model()->countByEntity($photo->getAttachByEntity('ContestWork')->model, 'mailru')?></span>
    </a>

    <a class="custom-like-small" href="javascript:void(0)" onclick="Share.vkontakte('<?=Yii::app()->request->hostInfo . Yii::app()->request->url?>', '<?=$photo->w_title?>', '<?=$photo->getPreviewUrl(960, 627, Image::HEIGHT, true)?>', '')">
        <span class="custom-like-small_icon vk"></span>
        <span class="custom-like-small_value"><?=Rating::model()->countByEntity($photo->getAttachByEntity('ContestWork')->model, 'vk')?></span>
    </a>

    <a class="custom-like-small" href="javascript:void(0)" onclick="Share.facebook('<?=Yii::app()->request->hostInfo . Yii::app()->request->url?>', '<?=$photo->w_title?>', '<?=$photo->getPreviewUrl(960, 627, Image::HEIGHT, true)?>', '')">
        <span class="custom-like-small_icon fb"></span>
        <span class="custom-like-small_value"><?=Rating::model()->countByEntity($photo->getAttachByEntity('ContestWork')->model, 'fb')?></span>
    </a>
    <div class="custom-likes-small_rating"><?=Rating::model()->countByEntity($photo->getAttachByEntity('ContestWork')->model, false)?></div>
</div>

<div class="margin-b10 textalign-c clearfix">
    <?php if ($prev): ?>
        <a href="<?=$this->createUrl('albums/singlePhoto', array('entity' => 'Contest', 'photo_id' => $prev->photoAttach->photo->id, 'contest_id' => $model->id))?>" class="btn-lilac btn-medium float-l"><i class="ico-arrow ico-arrow__left"></i> Назад</a>
    <?php endif; ?>
    <?php if ($next): ?>
        <a href="<?=$this->createUrl('albums/singlePhoto', array('entity' => 'Contest', 'photo_id' => $next->photoAttach->photo->id, 'contest_id' => $model->id))?>" class="btn-green btn-medium float-r">Вперед <i class="ico-arrow ico-arrow__right"></i></a>
    <?php endif; ?>
    <span class="page-numer"><?=$currentIndex?></span>
</div>