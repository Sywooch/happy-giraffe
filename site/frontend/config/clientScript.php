<?php

return array(
    'class' => 'application.components.ClientScript',
    'packages' => array(
        'bootstrap' => array(
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
        'ko_registerWidget' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_registerWidget.js',
            ),
            'depends' => array('knockout', 'common', 'jcrop', 'ko_upload'),
        ),
        'powertip' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/jquery.powertip.js',
            ),
        ),
		'scrollTo' => array(
            'baseUrl' => '/',
            'js' => array(
                'new/javascript/jquery.scrollTo.min.js',
            ),
			'depends' => array('jquery'),
		),
		'scrollEvents' => array(
            'baseUrl' => '/',
            'js' => array(
                'new/javascript/scroll-events.js',
            ),
			'depends' => array('jquery'),
		),
		'common' => array(
            'baseUrl' => '/',
            'js' => array(
				'new/javascript/jquery.magnific-popup.js',
                'new/javascript/select2.js',
                'new/javascript/select2_locale_ru.js',
                'new/javascript/jquery.tooltipster.js',
                'new/javascript/common.js',
                'javascripts/base64.js',
            ),
			'depends' => array(
				'jquery',
				'scrollTo',
				'scrollEvents',
				'comet',
			),
		),
        'jcrop' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/jquery.Jcrop.min.js',
            ),
            'css' => array(
                'stylesheets/jquery.Jcrop.min.css',
            ),
            'depends' => array('jquery'),
        ),
        'comet' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/comet.js',
                'javascripts/dklab_realplexor.js',
            ),
        ),
		'moment' => array(
			'baseUrl' => '/',
			'js' => array(
				'javascripts/moment.ru.min.js',
			),
		),
        'knockout' => array(
            'baseUrl' => '/',
            'js' => array(
                'new/javascript/knockout-debug.3.0.0.js',
                'javascripts/ko_library.js',
                'javascripts/knockout.mapping-latest.js',
            ),
            'depends' => array(
                'jquery',
				'moment',
            ),
        ),
        'history' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/history.js',
            ),
        ),
        'history2' => array(
            'baseUrl' => '/',
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
                'javascripts/knockout.mapping-latest.js',
                'javascripts/comments.js',
            ),
            'depends' => array('knockout'),
        ),
        'gallery' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_gallery.js',
            ),
            'depends' => array('knockout', 'ko_comments', 'history2', 'preload', 'powertip', 'wysiwyg', 'baron'),
        ),
        'ko_post' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_post.js',
            ),
            'depends' => array('knockout', 'ko_favourites', 'ko_upload', 'baron'),
        ),
        'ko_blog' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_blog.js',
            ),
            'depends' => array('knockout', 'gallery', 'jcrop', 'ko_upload'),
        ),
        'ko_community' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_community.js',
                'javascripts/ko_photoWidget.js',
            ),
            'depends' => array('ko_blog', 'ko_upload'),
        ),
        'ko_profile' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_gallery.js',
                'javascripts/ko_user_profile.js',
                'javascripts/ko_blog.js',
            ),
            'depends' => array('knockout', 'gallery', 'jcrop', 'ko_comments', 'ko_upload'),
        ),
        'ko_search' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_search.js',
            ),
            'depends' => array('knockout'),
        ),
        'ko_friends' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_friends.js',
                'javascripts/ko_friendsSearch.js',
            ),
            'depends' => array('knockout'),
        ),
        'ko_im' => array(
            'baseUrl' => '/',
            'js' => array(
                //'javascripts/im.js',
                'javascripts/ko_messaging.js',
                'new/javascript/fast-message.js',
                'javascripts/knockout.mapping-latest.js',
                'javascripts/soundmanager2.js',
            ),
            'depends' => array('knockout', 'common', 'comet', 'jquery.ui', 'wysiwyg', 'baron'),
        ),
        'ko_favourites' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_favourites.js',
            ),
            'depends' => array('knockout', 'history'),
        ),
        'ko_family' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_family.js',
            ),
            'depends' => array('knockout', 'jquery.ui', 'touchPunch'),
        ),
        'ko_photo' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_photo.js',
            ),
            'depends' => array('knockout', 'jquery_file_upload', 'bootstrap', 'baron', 'jquery.ui'),
        ),
        'ko_upload' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/upload.js',
            ),
            'depends' => array('knockout', 'jquery_file_upload'),
        ),
        'jquery_file_upload' => array(
            'baseUrl' => '/',
            'js' => array(
                'jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
                'jQuery-File-Upload/js/jquery.iframe-transport.js',
                'jQuery-File-Upload/js/jquery.fileupload.js',
                'jQuery-File-Upload/js/jquery.fileupload-process.js',
                'jQuery-File-Upload/js/jquery.fileupload-image.js',
            ),
            'depends' => array('jquery', 'blob', 'load_image'),
        ),
        'blob' => array(
            'baseUrl' => '/',
            'js' => array(
                'JavaScript-Canvas-to-Blob-master/js/canvas-to-blob.js',
            ),
            'depends' => array('jquery'),
        ),
        'load_image' => array(
            'baseUrl' => '/',
            'js' => array(
                'JavaScript-Load-Image-master/js/load-image.js',
                'JavaScript-Load-Image-master/js/load-image-meta.js',
            ),
            'depends' => array('jquery'),
        ),
        'ko_menu' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_menu.js',
            ),
            'depends' => array('knockout'),
        ),
        'ko_recipes_search' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_recipes_search.js',
            ),
            'depends' => array('knockout'),
        ),
        'ko_antispam' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_antispam.js',
            ),
            'depends' => array('knockout', 'powertip'),
        ),
        'ko_onlineManager' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_onlineManager.js',
            ),
            'depends' => array('knockout'),
        ),
        'redactor' => array(
            'baseUrl' => '/new/',
            'js' => array(
                'redactor/redactor.js',
                'redactor/lang/ru.js',
                '/redactor/plugins/toolbarVerticalFixed/toolbarVerticalFixed.js',
            ),
            'depends' => array('jquery', 'ko_upload'),
        ),
        'wysiwyg' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/imagesloaded.pkgd.min.js',
                'javascripts/wysiwyg.js',
                'new/javascript/wysiwyg.js',
            ),
            'depends' => array('redactor', 'common'),
        ),
        'baron' => array(
            'baseUrl' => '/',
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
    )
);