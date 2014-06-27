<?php
/**
 * @var $form site\frontend\modules\photo\models\upload\PopupForm
 */
?>

<div id="photo-tab-album" class="tab-pane active">
    <ul class="tabs-simple nav nav-tabs">
        <li class="active"><a href="#photo-albums">Мои альбомы <span data-bind="text: albums.length"></span></a></li>
    </ul>
    <div class="tab-content">
        <div id="photo-albums" class="tab-pane active">
            <div class="popup-add_scroll scroll">
                <div class="popup-add_frame popup-add_frame__album">
                    <div class="scroll_scroller">
                        <!-- Список альбомов-->
                        <div class="album-preview album-preview__album scroll_cont">
                            <ul class="album-preview_ul">
                                <!-- ko foreach: albums -->
                                <li class="album-preview_li">
                                    <div class="album-preview_in">
                                        <div class="album-preview_img-hold">
                                            <!-- --><img src="" alt="" class="album-preview_img" data-bind="attr: { src : cover.coverUrl }">
                                        </div>
                                        <div class="album-preview_overlay"></div>
                                    </div>
                                    <div class="album-preview_hold">
                                        <div class="album-preview_t" data-bind="text: title"></div>
                                        <div class="album-preview_count"><span data-bind="text: count"></span> фото</div>
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
            <!-- Пустой список фото в альбоме-->
        </div>
    </div>
</div>

<script type="text/javascript">
    albums = new FromAlbumsViewModel(<?=CJSON::encode($form->getAlbumsJSON())?>);
    ko.applyBindings(albums, document.getElementById('photo-tab-album'));
</script>