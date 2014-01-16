<?php

return array(
    'class' => 'application.components.ClientScript',
    'packages' => array(
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
                'new/javascript/common.js',
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
                'javascripts/knockout-2.2.1.js',
                'javascripts/ko_library.js',
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
        'ko_comments' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/knockout.mapping-latest.js',
                'javascripts/comments.js',
                'javascripts/wysiwyg.js',
            ),
            'depends' => array('knockout'),
        ),
        'gallery' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_gallery.js',
            ),
            'depends' => array('knockout', 'ko_comments'),
        ),
        'ko_post' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_post.js',
                'javascripts/baron.js',
            ),
            'depends' => array('knockout', 'ko_favourites', 'ko_upload'),
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
                'javascripts/wysiwyg.js',
                'javascripts/imagesloaded.pkgd.min.js',
				'javascripts/baron.js',
            ),
            'depends' => array('knockout', 'common', 'comet', 'jquery.ui'),
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
            'depends' => array('knockout', 'jquery.ui'),
        ),
        'ko_upload' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/upload.js',
                'jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
                'jQuery-File-Upload/js/jquery.iframe-transport.js',
                'jQuery-File-Upload/js/jquery.fileupload.js',
            ),
            'depends' => array('knockout'),
        ),
        'ko_layout' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_layout.js',
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
        'ko_onlineManager' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_onlineManager.js',
            ),
            'depends' => array('knockout'),
        ),
    )
);