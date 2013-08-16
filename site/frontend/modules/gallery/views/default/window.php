<?php
$model = AlbumPhoto::model()->findByPk($json['initialPhotoId']);
?>
<div class="photo-window" id="photo-window">
    <div class="photo-window_w">
        <div class="photo-window_top clearfix">
            <a href="javascript:void(0)" class="photo-window_close" onclick="PhotoCollectionViewWidget.close()"></a>
            <div class="b-user-small float-l">
                <a class="ava small" data-bind="attr: { href : currentPhoto().user.url }, css: currentPhoto().user.avaCssClass"><img data-bind="visible: currentPhoto().user.ava.length > 0, attr: { src : currentPhoto().user.ava }"></a>
                <div class="b-user-small_hold">
                    <a class="b-user-small_name" data-bind="html: currentPhoto().user.firstName + ' <br>' + currentPhoto().user.lastName, attr: { href : currentPhoto().user.url }"></a>
                    <div class="b-user-small_date" data-bind="text: currentPhoto().date"></div>
                </div>
            </div>
            <div class="photo-window_top-hold">
                <div class="photo-window_count" data-bind="text: currentNaturalIndex() + ' фото из ' + count"></div>
                <div class="photo-window_t" data-bind="text: currentPhoto().title"></div>
            </div>

        </div>
        <!-- Обрабатывать клик на юphoto-window_c для листания следующего изображения -->
        <div class="photo-window_c">
            <div class="photo-window_img-hold">
                <img alt="" class="photo-window_img" data-bind="attr: { src : currentPhoto().src }">
                <div class="verticalalign-m-help"></div>
            </div>
            <a class="photo-window_arrow photo-window_arrow__l" data-theme="white-simple" data-bind="click: prevHandler"></a>
            <a class="photo-window_arrow photo-window_arrow__r" data-theme="white-simple" data-bind="click: nextHandler"></a>


            <div class="like-control clearfix">

                <!-- ko with: currentPhoto() -->
                    <a href="" class="like-control_ico like-control_ico__like" data-bind="click: like, text: likesCount, css: {active: isLiked()}, tooltip: 'Нравится'" ></a>
                    <!-- ko with: favourites() -->
                        <?php $this->widget('FavouriteWidget', array('model' => $model, 'applyBindings' => false)); ?>
                    <!-- /ko -->
                <!-- /ko -->
            </div>
        </div>

        <!-- ko if: currentPhoto().description.length > 0 -->
        <div class="photo-window_bottom" data-bind="click: currentPhoto().toggleShowFullDescription, css: { active : currentPhoto().showFullDescription }">
            <div class="photo-window_desc">
                <p><span data-bind="text: currentPhoto().hasLongDescription() ? currentPhoto().shortenDescription() : currentPhoto().description"></span> <span class="photo-window_desc-more" data-bind="visible: currentPhoto().hasLongDescription()"> ... <a href="javascript:void(0)" >Читать полностью</a> </span></p>
            </div>
            <div class="photo-window_desc photo-window_desc__full">
                <p><span data-bind="text: currentPhoto().description"></span> <a href="javascript:void(0)">Кратко</a></p>
            </div>
        </div>
        <!-- /ko -->

        <!-- ko stopBinding: true  -->
        <div id="js-gallery-comment">
            <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $model, 'full' => true, 'gallery' => true)); ?>
        </div>
        <!-- /ko -->

    </div>
    <style type="text/css">
        body {overflow: hidden !important;}
    </style>
</div>
<script type="text/javascript">
    photoViewVM = new PhotoCollectionViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(photoViewVM, document.getElementById('photo-window'));
</script>