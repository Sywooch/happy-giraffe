<?php

return array(
    'class' => 'application.components.ClientScript',
    'amdFile' => '/new/javascript/modules/require2.1.11-jquery1.10.2.js',
    'amd' => array(
        'baseUrl' => '/new/javascript/modules',
        'waitSeconds' => 0,
        'wrapShim' => false,
        'shim' => array(
        ),
        'paths' => array(
            'knockout-amd-helpers' => 'knockout-amd-helpers.min',
            'wysiwyg' => '/new/javascript/wysiwyg',
        ),
        /*'eval' => '
            ko.amdTemplateEngine.defaultPath = "/new/javascript/modules";
            ko.amdTemplateEngine.defaultSuffix = ".tmpl.html";
            ',*/
    ),
    'packages' => array(
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
                'baron'
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
            'amd' => true,
            'js' => array(
                'javascripts/dklab_realplexor.js',
                'javascripts/comet.js',
            ),
        ),
		'moment' => array(
			'baseUrl' => '/',
            'amd' => true,
			'js' => array(
				'javascripts/moment.ru.min.js',
			),
		),
        'ko_library' => array(
            'baseUrl' => '/',
            'amd' => true,
			'js' => array(
                'javascripts/ko_library.js',
            ),
            'depends' => array( 'knockout', 'moment' ),
        ),
        'knockout' => array(
            'baseUrl' => '/',
            'js' => array(
                'new/javascript/knockout-debug.3.0.0.js',
                'javascripts/knockout.mapping-latest.js',
            ),
        ),
        'wysiwyg' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/wysiwyg.js',
            ),
            'depends' => array(
                'ko_upload',
            ),
        ),
        'baron' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/baron.js',
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
            'amd' => true,
            'js' => array(
                //'javascripts/knockout.mapping-latest.js',
                'javascripts/comments.js',
                //'javascripts/wysiwyg.js',
            ),
            'depends' => array('knockout', 'wysiwyg', 'ko_library'),
        ),
        'gallery' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_gallery.js',
            ),
            'depends' => array('knockout', 'ko_comments', 'history2', 'preload', 'powertip'),
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
                'javascripts/ko_friends.js',
                'javascripts/ko_friendsSearch.js',
            ),
            'depends' => array('knockout', 'ko_library'),
        ),
        'soundmanager' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/soundmanager2.js',
            ),
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
        'jquery.ui.widget' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
            ),
        ),
        'ko_upload' => array(
            'baseUrl' => '/',
            'amd' => true,
            'js' => array(
                'javascripts/upload.js',
                'jQuery-File-Upload/js/jquery.iframe-transport.js',
                'jQuery-File-Upload/js/jquery.fileupload.js',
            ),
            'depends' => array('knockout', 'jquery.ui.widget', 'ko_library'),
        ),
        'ko_menu' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_menu.js',
            ),
            'depends' => array('knockout', 'ko_library'),
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
            'depends' => array('knockout', 'powertip'),
        ),
        'ko_onlineManager' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_onlineManager.js',
            ),
            'depends' => array('knockout', 'ko_library'),
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
        'ko_registerWidget' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_registerWidget.js',
            ),
            'depends' => array('knockout', 'common', 'jcrop', 'ko_upload', 'ko_library'),
        ),
    )
);
