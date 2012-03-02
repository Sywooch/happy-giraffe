<div id="gallery">
    <div class="header">
        <div class="clearfix">
            <div class="user">
                <?php $this->widget('AvatarWidget', array('user' => $photo->user, 'withMail' => false)); ?>
                <p><span><?php echo $photo->user->fullName; ?></span>
                    <?php if($photo->user->country): ?>
                        <br><?php echo $photo->user->country->name; ?></p>
                    <?php endif; ?>
            </div>
            <div class="back-link">&larr; <?php echo CHtml::link('В анкету', array('/user/profile', 'user_id' => $photo->user->id)) ?></div>
        </div>
    </div>
    <div id="photo">
        <div class="title"><?php echo $photo->description; ?></div>

        <div class="ad-gallery">
            <div class="ad-image-container">
                <div class="ad-image-wrapper">
                </div>
            </div>
            <div class="ad-controls">
            </div>
            <div class="ad-nav">
                <div class="ad-thumbs gallery-photos">
                    <ul class="ad-thumb-list">
                        <?php foreach($photo->album->photos as $i => $item): ?>
                            <?php if($photo->id == $item->id) {$selected_item = $i;} ?>
                            <li>
                                <a href="<?php echo $item->getPreviewUrl(400, 400, Image::HEIGHT); ?>">
                                    <table>
                                        <tr>
                                            <td class="img">
                                                <div>
                                                    <?php echo CHtml::image($item->getPreviewUrl(180, 180)); ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="title">
                                            <td align="center">
                                                <div><?php echo $item->description ?></div>
                                            </td>
                                        </tr>
                                    </table>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$js = "var galleries = $('.ad-gallery').adGallery({
    effect:'fade',
    description_wrapper: false,
    slideshow:{enable:false},
    thumb_opacity: 1,
    start_at_index : " . $selected_item . ",
    callbacks : {
        afterImageVisible : function() {
            $('#photo > div.title').text(this.thumbs_wrapper.find('li:eq('+this.current_index+') tr.title div').text());
        }
    }
});";
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.ad-gallery.js')
->registerCssFile(Yii::app()->baseUrl . '/stylesheets/jquery.ad-gallery.css')
->registerScript('init_ad_gallery', $js, CClientScript::POS_READY);
?>

<?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
    'title' => 'Вам понравилось фото?',
    'model' => $photo,
    'options' => array(
        'title' => $photo->description,
        'image' => $item->getPreviewUrl(180, 180),
        'description' => false,
    ),
)); ?>
<?php $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
    'model' => $photo,
)); ?>