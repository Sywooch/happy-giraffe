define(['jquery', 'knockout', 'text!photo-slider/photo-slider.html', 'photo/PhotoAlbum', 'user-config', 'extensions/imagesloaded', 'extensions/PresetManager', 'modules-helpers/component-custom-returner', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation', 'ko_library'], function ($, ko, template, PhotoAlbum, userConfig, imagesLoaded, PresetManager) {

    function PhotoSlider() {
        /* Height block comment scroll in photo-window */
        function photoWindColH () {
            var colCont = $(".photo-window_cont");
            var bannerH = document.getElementById('photo-window_banner').offsetHeight;
            colCont.height($(window).height() - bannerH - 24);

        }
        /* Позиция блока с лайками */
        function likePos () {
            var likeBottom = ($('.photo-window_img-hold').height() - $('.photo-window_img').height()) / 2 + 30;
            $('.photo-window .like-control').css({'bottom' : likeBottom});
        }

        $(document).ready(function () {
            photoWindColH();
            likePos();

            /* custom scroll */
            var scroll = $('.scroll').baron({
                scroller: '.scroll_scroller',
                barOnCls: 'scroll__on',
                container: '.scroll_cont',
                track: '.scroll_bar-hold',
                bar: '.scroll_bar'
            });
        });

        $(window).resize(function () {
            photoWindColH();
            likePos();
        });
    };

    return {
        viewModel: PhotoSlider,
        template: template
    };

});