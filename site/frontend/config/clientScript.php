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
        'knockout' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/knockout-2.2.1.js',
                'javascripts/ko_library.js',
            ),
            'depends' => array(
                'jquery',
                'powertip',
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
                'javascripts/comments.js?5',
                'javascripts/wysiwyg.js?3',
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
            ),
            'depends' => array('ko_blog', 'ko_upload'),
        ),
        'ko_profile' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_gallery.js',
                'javascripts/ko_user_profile.js?5',
                'javascripts/ko_blog.js',
            ),
            'depends' => array('knockout', 'gallery', 'jcrop', 'ko_comments', 'ko_upload'),
        ),
        'ko_search' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_search.js?3',
            ),
            'depends' => array('knockout'),
        ),
        'ko_friends' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/ko_friends.js?3',
                'javascripts/ko_friendsSearch.js',
            ),
            'depends' => array('knockout'),
        ),
        'ko_im' => array(
            'baseUrl' => '/',
            'js' => array(
                'javascripts/messaging.js',
                'javascripts/im.js',
                'javascripts/knockout.mapping-latest.js',
                'javascripts/soundmanager2.js',
                'javascripts/wysiwyg.js',
                'javascripts/imagesloaded.pkgd.min.js',
            ),
            'depends' => array('knockout', 'comet', 'jquery.ui'),
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
                'javascripts/upload.js?2',
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
    )
);