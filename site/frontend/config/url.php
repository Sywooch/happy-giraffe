<?php

return array(
    'urlFormat' => 'path',
    'showScriptName' => false,
    'urlSuffix' => '/',
    'useStrictParsing' => true,
    'rules' => array(
       /*************************
        *      CONTROLLERS      *
        *************************/

        // global
        '.*/index' => 404,

        // photo view
        'community/<community_id:\d+>/forum/post/<content_id:\d+>/photo<photo_id:\d+>' => array('albums/singlePhoto', 'defaultParams' => array('entity' => 'CommunityContentGallery')),
        'user/<user_id:\d+>/albums/<album_id:\d+>/photo<photo_id:\d+>' => array('albums/singlePhoto', 'defaultParams' => array('entity' => 'Album')),
        'cook/recipe/<recipe_id:\d+>/photo<photo_id:\d+>' => array('albums/singlePhoto', 'defaultParams' => array('entity' => 'SimpleRecipe')),
        'cook/multivarka/<recipe_id:\d+>/photo<photo_id:\d+>' => array('albums/singlePhoto', 'defaultParams' => array('entity' => 'MultivarkaRecipe')),
        'cook/decor/photo<photo_id:\d+>' => array('albums/singlePhoto', 'defaultParams' => array('entity' => 'CookDecorationCategory')),
        'cook/decor/<category_id:\d+>/photo<photo_id:\d+>' => array('albums/singlePhoto', 'defaultParams' => array('entity' => 'CookDecorationCategory')),

        // site controller
        '/' => 'site/index',
        'js_dynamics/<hash:\w+>.js' => 'site/seoHide',
        'search' => 'site/search',
        'site/rememberPassword/step/<step:\d+>' => 'site/rememberPassword',
        'site/<_a:(login|logout|link|test|users)>' => 'site/<_a>',
        'contest' => 'site/contest',

        // ajax controller
        'ajax/duelShow/question_id/<question_id:\d+>' => 'ajax/duelShow',

        // signup controller
        'signup' => 'signup/index',
        'signup/finish'=>'signup/finish',
        'signup/validate/step/<step:\d+>' => 'signup/validate',

        // friendRequests controller
        'friendRequests/update/request_id/<request_id:\d+>/action/<action:(accept|decline|retry|cancel)>' => 'friendRequests/update',

        // rss controller
        'rss/page<page:\d+>' => 'rss/index',

        // morning controller
        'morning/<id:\d+>' => 'morning/view',
        'morning/<date:[\d\d\d\d-\d\d-\d\d]*>' => 'morning/index',

        // albums controller
        'albums/addPhoto/a/<a:\d+>' => 'albums/addPhoto',
        'albums/addPhoto' => 'albums/addPhoto',
        'albums/redirect/<id:\d+>' => 'albums/redirect',
        'albums/<_a:(attach|wPhoto|attachView|editDescription|editPhotoTitle|changeTitle|changePermission|removeUploadPhoto|communityContentEdit|communityContentSave|recipePhoto|cookDecorationPhoto|cookDecorationCategory|commentPhoto|crop|changeAvatar|humorPhoto|albumSettings|updatePhoto|postLoad)>' => 'albums/<_a>',

        // user/*
        'user/<user_id:\d+>' => 'user/profile',
        'user/<user_id:\d+>/activity/page<page:\d+>' => 'user/activity',
        'user/<user_id:\d+>/activity' => 'user/activity',
        'user/<user_id:\d+>/clubs' => 'user/clubs',
        'user/<user_id:\d+>/friends' => 'user/friends',
        'user/<user_id:\d+>/blog/rubric<rubric_id:\d+>' => 'blog/list',
        'user/<user_id:\d+>/blog' => 'blog/list',
        'user/<user_id:\d+>/blog/post<content_id:\d+>' => 'blog/view',
        'user/<user_id:\d+>/rss/page<page:\d+>' => 'rss/user',
        'user/<user_id:\d+>/rss' => 'rss/user',
        'user/<user_id:\d+>/comments/rss/page<page:\d+>' => 'rss/comments',
        'user/<user_id:\d+>/comments/rss' => 'rss/comments',
        'user/<id:\d+>/albums' => 'albums/user',
        'user/<user_id:\d+>/albums/<id:\d+>' => 'albums/view',
        'user/<user_id:\d+>/albums/<album_id:\d+>/photo<id:\d+>' => 'albums/photo',
        'user/<_a:(updateMood)>' => 'user/<_a>',
        'user/createRelated/relation/<relation:\w+>/'=>'user/createRelated',
        'user/myFriendRequests/<direction:\w+>/'=>'user/myFriendRequests',

        //blog
        'blog/edit/content_id/<content_id:\d+>' => 'blog/edit',
        'blog/add/content_type_slug/<content_type_slug>' => 'blog/add',
        'blog/add/content_type_slug/<content_type_slug>/rubric_id/<rubric_id:\d+>' => 'blog/add',
        'blog/<_a:(add|empty)>' => 'blog/<_a>',

        // community/*
        'community/<community_id:\d+>/forum/rubric/<rubric_id:\d+>/<content_type_slug:\w+>' => 'community/list',
        'community/<community_id:\d+>/forum/rubric/<rubric_id:\d+>' => 'community/list',
        'community/<community_id:\d+>/forum/<content_type_slug:\w+>' => 'community/list',
        'community/<community_id:\d+>/forum' => 'community/list',
        'community/<community_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>' => 'community/view',
        'community/<community_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>/uploadImage' => 'community/uploadImage',

        'community/edit/content_id/<content_id:\d+>' => 'community/edit',
        'community/add/community_id/<community_id:\d+>/rubric_id/<rubric_id:\d+>/content_type_slug/<content_type_slug>' => 'community/add',
        'community/add/community_id/<community_id:\d+>/rubric_id/<rubric_id:\d+>' => 'community/add',
        'community/add/community_id/<community_id:\d+>/content_type_slug/<content_type_slug>' => 'community/add',
        'community/add/community_id/<community_id:\d+>' => 'community/add',
        'community/<_a:(join|add|transfer|edit|editTravel)>' => 'community/<_a>',

        //global
        '<_c:(activity|ajax|notification|profile|friendRequests|communityRubric|family|morning)>/<_a>' => '<_c>/<_a>',
        '<_c:(activity|profile|rss|family|morning|community)>' => '<_c>/index',

        //others
        array('class' => 'site.frontend.extensions.sitemapgenerator.SGUrlRule', 'route' => '/sitemap'),

        /*************************
         *        MODULES        *
         *************************/

        'contest/<id:\d+>' => 'contest/default/view',
        'contest/<id:\d+>/rules' => 'contest/default/rules',
        'contest/<id:\d+>/list/<sort:\w+>' => 'contest/default/list',
        'contest/<id:\d+>/list' => 'contest/default/list',
        'contest/<id:\d+>/results/work<work:\d+>' => 'contest/default/results',
        'contest/<id:\d+>/results' => 'contest/default/results',
        'contest/work<id:\d+>' => 'contest/default/work',
        'contest/<_a>/<id:\d+>' => 'contest/default/<_a>',

        '<_m:(geo|im|signal|scores|cook)>/' => '<_m>/default/index',
        '<_m:(geo|im|signal)>/<_a>' => '<_m>/default/<_a>',

        //cook
        'cook/calorisator/ac' => 'cook/calorisator/ac',

        'cook/choose/<id:[\w_]+>' => 'cook/choose/view',

        'cook/converter/<_a>' => 'cook/converter/<_a>',

        'cook/decor/<id:\d+>/page<page:\d+>' => 'cook/decor/index',
        'cook/decor/<id:\d+>' => 'cook/decor/index',
        'cook/decor/page<page:\d+>' => 'cook/decor/index',
        'cook/decor' => 'cook/decor/index',

        'cook/recipe/edit/<id:\d+>' => array('cook/recipe/form', 'defaultParams' => array('section' => 0)),
        'cook/recipe/add' => array('cook/recipe/form', 'defaultParams' => array('section' => 0)),
        'cook/recipe/<id:\d+>' => array('cook/recipe/view', 'defaultParams' => array('section' => 0)),
        'cook/recipe/type/<type:\d+>' => array('cook/recipe/index', 'defaultParams' => array('section' => 0)),
        'cook/recipe' => array('cook/recipe/index', 'defaultParams' => array('section' => 0)),
        'cook/recipe/advancedSearch' => array('cook/recipe/advancedSearch', 'defaultParams' => array('section' => 0)),
        'cook/recipe/advancedSearchResult' => array('cook/recipe/advancedSearchResult', 'defaultParams' => array('section' => 0)),
        'cook/recipe/searchByIngredients' => array('cook/recipe/searchByIngredients', 'defaultParams' => array('section' => 0)),
        'cook/recipe/searchByIngredientsResult' => array('cook/recipe/searchByIngredientsResult', 'defaultParams' => array('section' => 0)),

        'cook/recipe/edit/<id:\d+>' => array('cook/recipe/form', 'defaultParams' => array('section' => 0)),
        'cook/multivarka/add' => array('cook/recipe/form', 'defaultParams' => array('section' => 1)),
        'cook/multivarka/<id:\d+>' => array('cook/recipe/view', 'defaultParams' => array('section' => 1)),
        'cook/multivarka/type/<type:\d+>' => array('cook/recipe/index', 'defaultParams' => array('section' => 1)),
        'cook/multivarka' => array('cook/recipe/index', 'defaultParams' => array('section' => 1)),
        'cook/multivarka/advancedSearch' => array('cook/recipe/advancedSearch', 'defaultParams' => array('section' => 1)),
        'cook/multivarka/advancedSearchResult' => array('cook/recipe/advancedSearchResult', 'defaultParams' => array('section' => 1)),
        'cook/multivarka/searchByIngredients' => array('cook/recipe/searchByIngredients', 'defaultParams' => array('section' => 1)),
        'cook/multivarka/searchByIngredientsResult' => array('cook/recipe/searchByIngredientsResult', 'defaultParams' => array('section' => 1)),

        'cook/recipe/feed.xml' => 'cook/recipe/feed',
        'cook/recipe/<_a:(ac|import|search)>' => 'cook/recipe/<_a>',

        'cook/spices/category/<id:[\w_]+>' => 'cook/spices/category',
        'cook/spices/<id:[\w_]+>' => 'cook/spices/view',

        'cook/<_c:(spices|choose|calorisator|converter)>' => 'cook/<_c>/index',

        //===================== Services =========================//
        '<_m:(test|tester|vaccineCalenda|childrenDiseases|menstrualCycle|horoscope|babyBloodGroup|placentaThickness|pregnancyWeight|contractionsTime|names|recipeBook|hospitalBag|maternityLeave|dailyCalories|weightLoss|idealWeight|bodyFat|birthDate)>/' => 'services/<_m>/default/index',
        '<_m:(babySex|vaccineCalendar|sewing|hospitalBag)>/<_a>/' => 'services/<_m>/default/<_a>',

        'babySex'=>'services/babySex/default/index',
        'babySex/default/<_a:(bloodUpdate, japanCalc, ovulationCalc)>/' => 'services/babySex/default/<_a>',

        'childrenDiseases/<id:[\w-+\s]+>' => 'services/childrenDiseases/default/view',

        'horoscope/compatibility/validate' => 'services/horoscope/default/validate',
        'horoscope/compatibility/<zodiac1:[\w]+>/<zodiac2:[\w]+>' => 'services/horoscope/default/compatibility',
        'horoscope/compatibility/<zodiac1:[\w]+>' => 'services/horoscope/default/compatibility',
        'horoscope/compatibility' => 'services/horoscope/default/compatibility',
        'horoscope/<_a:(year|month|today|tomorrow|yesterday)>/<zodiac:[\w]+>' => 'services/horoscope/default/<_a>',
        'horoscope/<zodiac:[\w]+>/<date:[\d\d\d\d-\d\d-\d\d]*>' => 'services/horoscope/default/view',
        'horoscope/<zodiac:[\w]+>' => 'services/horoscope/default/view',

        'names/<_a:(saintCalc|likes|like|top10|saint)>' => 'services/names/default/<_a>',
        'names/<name:[\w]+>' => 'services/names/default/name/',

        'recipeBook/<_a:(getAlphabetList|getCategoryList|edit|list|diseases|vote)>' => 'services/recipeBook/default/<_a>',
        'recipeBook/recipe/<id:\d+>' => 'services/recipeBook/default/view',
        'recipeBook/<url:\w+>' => 'services/recipeBook/default/disease',

        'services/repair/<_c>/<_a>' => 'services/repair/<_c>/<_a>',
        'repair/<_c>' => 'services/repair/<_c>/index',

        'test/<slug:[\w-]+>' => 'services/test/default/view',

        'tester/<slug:[\w-]+>' => 'services/tester/default/view',

        '<_m:(menstrualCycle|placentaThickness|pregnancyWeight|birthDate)>/<_a:(calculate)>' => 'services/<_m>/default/<_a>',

        'services/<_m:(dailyCalories|weightLoss|idealWeight|bodyFat)>/default/<_c>' => 'services/<_m>/default/<_c>',
    ),
);