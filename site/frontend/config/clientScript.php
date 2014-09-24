<?php

return array(
    'class' => 'application.components.ClientScript',
    'amdFile' => '/new/javascript/modules/require2.1.11-jquery1.10.2.js',
    'amdFilePos' => CClientScript::POS_HEAD,
    'amd' => array(
        'baseUrl' => '/new/javascript/modules',
        'waitSeconds' => 0,
        'wrapShim' => false,
        'shim' => array(
            'AdFox' => array(),
        ),
        'paths' => array(
            'knockout-amd-helpers' => 'knockout-amd-helpers.min',
            'wysiwyg' => '/new/javascript/wysiwyg',
            'ko_library' => '/javascripts/ko_library',
            'ko_blog' => '/javascripts/ko_blog',
            'ko_post' => '/javascripts/ko_post',
            'ko_menu' => '/javascripts/ko_menu',
            'ko_favourites' => '/javascripts/ko_favourites',
            'ko_registerWidget' => '/javascripts/ko_registerWidget',
            'ko_community' => '/javascripts/ko_community',
            'ko_photoWidget' => '/javascripts/ko_photoWidget',
            'ko_comments' => '/javascripts/comments',
            'moment' => '/javascripts/moment.ru.min',
            'gallery' => '/javascripts/ko_gallery',
            'preload' => '/javascripts/jquery.preload.min',
            'favouriteWidget' => '/javascripts/FavouriteWidget',
            'imagesLoaded' => '/javascripts/imagesloaded.pkgd.min',
            'ko_photoUpload' => 'ko_photo',
            'AdFox' => '/javascripts/fox',
            'wysiwyg_old' => '/javascripts/wysiwyg',
            'upload' => '/javascripts/upload',
            'async' => '/new/javascript/plugins/async',
            'goog' => '/new/javascript/plugins/goog',
            'propertyParser' => '/new/javascript/plugins/propertyParser',
            'kow' => '/new/javascript/modules/kow',
            'comments-model' => '/new/javascript/modules/models/Comments',
            'comment-widget' => '/new/javascript/modules/comment-widget/comment-widget',
            'routesCalc' => 'routes',
        ),
        /* 'eval' => '
          ko.amdTemplateEngine.defaultPath = "/new/javascript/modules";
          ko.amdTemplateEngine.defaultSuffix = ".tmpl.html";
          ', */
    ),
    'litePackages' => array(
        'default' => array(
            'baseUrl' => '/lite/css/dev/',
            'guest' => array(
                'all.css' => array(
                    'pos' => CClientScript::POS_HEAD,
                    'inline' => false,
                ),
            ),
            'user' => array(
                'all.css' => array(
                    'pos' => CClientScript::POS_HEAD,
                    'inline' => false,
                ),
            ),
        ),
        'services' => array(
            'baseUrl' => '/lite/css/min/',
            'guest' => array(
                'services.css' => array(
                    'pos' => CClientScript::POS_END,
                    'inline' => false,
                ),
            ),
            'user' => array(
                'services-user.css' => array(
                    'pos' => CClientScript::POS_END,
                    'inline' => false,
                ),
            ),
            'depends' => array('default'),
        ),
        'routes' => array(
            'depends' => array('services'),
        ),
        'calendar' => array(
            'depends' => array('services'),
        ),
        'recipes' => array(
            'depends' => array('services'),
        ),
        'archive' => array(
            'depends' => array('services'),
        ),
    ),
    'packages' => array(
        'bootstrap' => array(
            'amd' => true,
            'baseUrl' => '/',
            'js' => array(
                'new/javascript/bootstrap/dropdown.js',
                'new/javascript/bootstrap/tab.js',
            ),
        ),
        'userSettings' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_userSettings.js',
            ),
        ),
        'ko_settings' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_settings.js',
            ),
            'depends' => array('knockout', 'userSettings'),
        ),
        'touchPunch' => array(
            'baseUrl' => '/',
            'js' => array(
                'new/javascript/jquery.ui.touch-punch.min.js',
            ),
        ),
        'powertip' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/jquery.powertip.js',
            ),
        ),
        'base64' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/base64.js',
            ),
        ),
        'scrollTo' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'new/javascript/jquery.scrollTo.min.js',
            ),
            'depends' => array('jquery'),
        ),
        'scrollEvents' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'new/javascript/scroll-events.js',
            ),
            'depends' => array('jquery'),
        ),
        'common' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'new/javascript/jquery.magnific-popup.js',
                'new/javascript/select2.js',
                'new/javascript/select2_locale_ru.js',
                'new/javascript/jquery.tooltipster.js',
                'new/javascript/common.js',
            ),
            'depends' => array(
                'jquery',
                'scrollTo',
                'scrollEvents',
                'comet',
                'base64',
                'baron',
                'addtocopy',
                'jquery.placeholder',
                'jquery.fancybox',
                'powertip',
            ),
        ),
        'addtocopy' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/addtocopy.js'
            ),
            'depends' => array('jquery'),
        ),
        'jquery.fancybox' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/jquery.fancybox-1.3.4.js'
            ),
            'depends' => array('jquery'),
        ),
        'jquery.placeholder' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/jquery.placeholder.min.js'
            ),
            'depends' => array('jquery'),
        ),
        'jquery.flydiv' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/jquery.flydiv.js'
            ),
            'depends' => array('jquery'),
        ),
        'jcrop' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/jquery.Jcrop.min.js',
            ),
            'css' => array(
                'stylesheets/jquery.Jcrop.min.css',
            ),
            'depends' => array('jquery'),
        ),
        'realplexor' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/dklab_realplexor.js',
            ),
        ),
        'comet' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/comet.js',
            ),
            'depends' => array('realplexor'),
        ),
        'moment' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/moment.ru.min.js',
            ),
        ),
        'ko_library' => array(
            'baseUrl' => '/',
            //'amd' => true,
            'js' => array(
                'javascripts/ko_library.js',
            ),
            'depends' => array('knockout', 'moment', 'wysiwyg'),
        ),
        'knockout' => array(
            'baseUrl' => '/',
            'js' => array(
                'new/javascript/knockout-debug.3.0.0.js',
                'javascripts/knockout.mapping-latest.js',
            ),
            'depends' => array('jquery'),
        ),
        'imagesLoaded' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/imagesloaded.pkgd.min.js',
            ),
        ),
        'wysiwyg' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/wysiwyg.js',
                'new/javascript/wysiwyg.js',
            ),
            'depends' => array(
                'jquery',
                'ko_upload',
                'redactor',
                'imagesloaded',
            ),
        ),
        'history' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/history.js',
            ),
        ),
        'history2' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/jquery.history.js',
            ),
        ),
        'preload' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/jquery.preload.min.js',
            ),
        ),
        'ko_comments' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/comments.js',
            ),
            'depends' => array('knockout', 'wysiwyg', 'ko_library'),
        ),
        'gallery' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_gallery.js',
            ),
            'depends' => array('knockout', 'favouriteWidget', 'ko_comments', 'history2', 'preload', 'powertip'),
        ),
        'ko_post' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_post.js',
                //'javascripts/baron.js',
            ),
            'depends' => array('knockout', 'baron', 'ko_favourites', 'ko_upload', 'ko_library'),
        ),
        'ko_blog' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_blog.js',
            ),
            'depends' => array('knockout', 'gallery', 'jcrop', 'ko_upload', 'ko_library'),
        ),
        'ko_community' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_community.js',
                'javascripts/ko_photoWidget.js',
            ),
            'depends' => array('ko_blog', 'ko_upload', 'ko_library'),
        ),
        'ko_profile' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_user_profile.js',
                'javascripts/ko_blog.js',
            ),
            'depends' => array('knockout', 'gallery', 'jcrop', 'ko_comments', 'ko_upload', 'ko_library'),
        ),
        'ko_search' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_search.js',
            ),
            'depends' => array('knockout', 'ko_library'),
        ),
        'ko_friends' => array(
            'baseUrl' => '/',
            'js' => array(
                'new/javascript/modules/ko_friends.js',
                'new/javascript/modules/ko_friendsSearch.js',
            ),
            'depends' => array('knockout', 'ko_library', 'history2'),
        ),
        'soundmanager' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/soundmanager2.js',
            ),
            'depends' => array('knockout', 'common', 'comet', 'jquery.ui', 'wysiwyg', 'baron'),
        ),
        'ko_favourites' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_favourites.js',
            ),
            'depends' => array('knockout', 'history', 'ko_library'),
        ),
        'ko_family' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_family.js',
            ),
            'depends' => array('knockout', 'jquery.ui', 'ko_library'),
        ),
        'jquery.ui' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'new/javascript/jquery-ui-1.10.4.min.js',
            ),
            'depends' => array('jquery'),
        ),
        'jquery.ui.widget' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
            ),
            'depends' => array('jquery'),
        ),
        'ko_upload' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/upload.js',

            ),
            'depends' => array('knockout', 'jquery_file_upload'),
        ),
        'jquery_file_upload' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'jQuery-File-Upload/js/jquery.iframe-transport.js',
                'jQuery-File-Upload/js/jquery.fileupload.js',
            ),
            'depends' => array('jquery', 'jquery.ui.widget'),
        ),
        'ko_menu' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_menu.js',
            ),
            'depends' => array('knockout', 'ko_library', 'comet'),
        ),
        'ko_recipes_search' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_recipes_search.js',
            ),
            'depends' => array('knockout', 'ko_library'),
        ),
        'ko_antispam' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_antispam.js',
            ),
            'depends' => array('knockout', 'powertip', 'ko_post'),
        ),
        'ko_onlineManager' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_onlineManager.js',
            ),
            'depends' => array('knockout', 'ko_library'),
        ),
        'redactor' => array(
            'amd' => true,
            'baseUrl' => '/new/',
            'js' => array(
                'redactor/redactor.js',
                'redactor/lang/ru.js',
                'redactor/plugins/toolbarVerticalFixed/toolbarVerticalFixed.js',
            ),
            'depends' => array('jquery', 'ko_upload'),
        ),
        'ko_registerWidget' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_registerWidget.js',
            ),
            'depends' => array('jquery', 'knockout', 'common', 'jcrop', 'ko_upload', 'ko_library'),
        ),
        'favouriteWidget' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/FavouriteWidget.js',
                'javascripts/imagesloaded.pkgd.min.js',
            ),
            'depends' => array('knockout', 'wysiwyg', 'jquery', 'jquery.flydiv'),
        ),
        'baron' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/baron.js',
            ),
            'depends' => array('jquery'),
        ),
        'vacancy' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/vacancy.js',
            ),
            'depends' => array('ko_upload'),
        ),
        'rowGrid' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'new/javascript/jquery.row-grid.min.js',
            ),
            'depends' => array('jquery'),
        ),
        'lite' => array(
            'amd' => true,
            'baseUrl' => '/',
            'js' => array(
                'lite/javascript/modernizr.custom.js',
                'lite/javascript/picturefill.min.js',
            ),
        ),
        'lite-default' => array(
            'css' => array(
                '/lite/css/dev/all.css'
            ),
            'depends' => array('lite'),
        ),
        'lite_services' => array(
            'amd' => true,
            'baseUrl' => '/',
            'css' => array(
                'lite/css/min/services.css',
            ),
        ),
        'lite_services_user' => array(
            'amd' => true,
            'baseUrl' => '/',
            'css' => array(
                'lite/css/min/services-user.css',
            ),
        ),
        'lite_routes' => array(
            'depends' => array('lite_services'),
        ),
        'lite_routes_user' => array(
            'depends' => array('lite_services_user'),
        ),
        'lite_calendar' => array(
            'depends' => array('lite_services'),
        ),
        'lite_calendar_user' => array(
            'depends' => array('lite_services_user'),
        ),
        'lite_recipes' => array(
            'depends' => array('lite_services'),
        ),
        'lite_recipes_user' => array(
            'depends' => array('lite_services_user'),
        ),
        'lite_archive' => array(
            'depends' => array('lite_services'),
        ),
        'lite_archive_user' => array(
            'depends' => array('lite_services_user'),
        ),
        'chosen' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/chosen.jquery.min.js',
            ),
            'depends' => array('jquery'),
        ),
    )
);
