<?php
/**
 * @var $form site\frontend\modules\photo\models\upload\PopupForm
 */
?>

<div id="photo-tab-album" class="tab-pane">
    <ul class="tabs-simple nav nav-tabs">
        <li data-bind="css: { active: currentAlbum() === null }"><a href="" data-bind="click: unselectAlbum">Мои альбомы <span data-bind="text: albums().length"></span></a></li>
        <li data-bind="with: currentAlbum(), css: { active: currentAlbum() !== null }"><a href="" data-bind="click: $root.selectAlbum"><span data-bind="text: title"></span> <span data-bind="text: photoCollection().attachesCount()"></span></a></li>
        <!--<li><a href="#photo-album-all" data-toggle="tab">Все фото 468</a></li>-->
    </ul>
    <div class="tab-content">
        <div class="popup-add_scroll scroll">
            <div class="popup-add_frame popup-add_frame__album">
                <div class="scroll_scroller">
                    <div class="album-preview album-preview__album scroll_cont" data-bind="visible: currentAlbum() === null">
                        <ul class="album-preview_ul">
                            <!-- ko foreach: albums -->
                            <li class="album-preview_li" data-bind="click: $root.selectAlbum">
                                <div class="album-preview_in">
                                    <div class="album-preview_img-hold">
                                        <img src="" alt="" class="album-preview_img" data-bind="thumb: { photo: photoCollection().cover(), preset: 'uploadAlbumCover' }">
                                    </div>
                                    <div class="album-preview_overlay"></div>
                                </div>
                                <div class="album-preview_hold">
                                    <div class="album-preview_t" data-bind="text: title"></div>
                                    <div class="album-preview_count"><span data-bind="text: photoCollection().attachesCount()"></span> фото</div>
                                </div>
                            </li>
                            <!-- /ko -->
                        </ul>
                    </div>

                    <div class="album-preview scroll_cont" data-bind="with: currentAlbum(), css: thumbsSizeClass">
                        <ul class="album-preview_ul">
                            <!-- ko foreach: photoCollection().attaches() -->
                            <li class="album-preview_li" data-bind="click: $root.selectAttach, css: { active: isActive }">
                                <div class="album-preview_in">
                                    <div class="album-preview_img-hold">
                                        <img src="" alt="" class="album-preview_img" data-bind="thumb: { photo: photo(), preset: $root.thumbsPreset() }">
                                    </div>
                                    <div class="album-preview_overlay"></div>
                                    <div class="album-preview_check"></div>
                                </div>
                            </li>
                            <!-- /ko -->
                        </ul>
                    </div>
                </div>
                <div class="scroll_bar-hold">
                    <div class="scroll_bar">
                        <div class="scroll_bar-in"></div>
                    </div>
                </div>
            </div>
            <div class="popup-add_footer clearfix" data-bind="visible: currentAlbum() !== null">
                <div class="popup-add_footer-l">
                    <div class="album-slider">
                        <div class="album-slider_tx album-slider_tx-minus" data-bind="click: function() { updateThumbsSize(-1) }">&ndash;</div>
                        <div class="album-slider_hold" data-bind="slider: thumbsSize, sliderOptions: { min: 1, max: 3 }"></div>
                        <div class="album-slider_tx album-slider_tx-plus" data-bind="click: function() { updateThumbsSize(1) }">+</div>
                    </div>
                </div>
                <div class="float-r">
                    <div class="btn btn-link-gray btn-s disabled">Выберите фото </div><button href="" class="btn btn-success" data-bind="click: add, disable: photos().length == 0">Добавить</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    albums = new FromAlbumsViewModel(<?=$form->output()?>);
    ko.applyBindings(albums, document.getElementById('photo-tab-album'));
</script>