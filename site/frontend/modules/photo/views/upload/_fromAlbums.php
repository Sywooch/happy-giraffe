<?php
/**
 * @var $form site\frontend\modules\photo\models\upload\PopupForm
 */
?>

<div id="photo-tab-album" class="tab-pane active">
    <ul class="tabs-simple nav nav-tabs">
        <li class="active"><a href="#photo-albums">Мои альбомы <span data-bind="text: albums().length"></span></a></li>
        <li><a href="#photo-album-all">Все фото 468</a></li>
    </ul>
    <div class="tab-content">
        <div id="photo-albums" class="tab-pane active">
            <div class="popup-add_scroll scroll">
                <div class="popup-add_frame popup-add_frame__album">
                    <div class="scroll_scroller">
                        <div class="album-preview album-preview__album scroll_cont" data-bind="if: currentAlbum() === null">
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

                        <div class="album-preview album-preview__m scroll_cont" data-bind="if: currentAlbum() !== null">
                            <ul class="album-preview_ul">
                                <!-- ko foreach: currentAlbum().photoCollection().attaches() -->
                                <li class="album-preview_li" data-bind="with: photo">
                                    <div class="album-preview_in">
                                        <div class="album-preview_img-hold">
                                            <img src="" alt="" class="album-preview_img" data-bind="thumb: { photo: $data, preset: 'uploadPreview' }">
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
            </div>
        </div>
        <div id="photo-album-open">

        </div>
    </div>
</div>

<script type="text/javascript">
    albums = new FromAlbumsViewModel(<?=$form?>);
    ko.applyBindings(albums, document.getElementById('photo-tab-album'));
</script>