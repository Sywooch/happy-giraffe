<?php

return array(
    'class' => 'ext.sitemapgenerator.SGController',
    'import' => array(
        'routes.models.Route'
    ),
    'config' => array(
        'sitemap.xml' => array(
            'index' => true,
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
        'sitemapCommunity1' => array(
            'aliases' => array(
                'application.modules.posts.controllers.PostController',
            ),
            'changefreq' => 'daily',
            'param' => array('page' => 1, 'service' => 'oldCommunity'),
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
        'sitemapCommunity2' => array(
            'aliases' => array(
                'application.modules.posts.controllers.PostController',
            ),
            'changefreq' => 'daily',
            'param' => array('page' => 2, 'service' => 'oldCommunity'),
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
        'sitemapBlog1' => array(
            'aliases' => array(
                'application.modules.posts.controllers.PostController',
            ),
            'changefreq' => 'daily',
            'param' => array('page' => 1, 'service' => 'oldBlog'),
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
        'sitemapBlog2' => array(
            'aliases' => array(
                'application.modules.posts.controllers.PostController',
            ),
            'changefreq' => 'daily',
            'param' => array('page' => 2, 'service' => 'oldBlog'),
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
        'sitemapCook.xml' => array(
            'aliases' => array(
                'application.modules.cook.controllers.SpicesController',
                'application.modules.cook.controllers.ChooseController',
                'application.modules.cook.controllers.RecipeController',
            ),
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
        'sitemapDecor.xml' => array(
            'aliases' => array(
                'application.modules.cook.controllers.DecorController',
            ),
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
        'sitemapRoutes1.xml' => array(
            'aliases' => array(
                'application.modules.routes.controllers.DefaultController',
            ),
            'param' => 1,
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
        'sitemapRoutesAll.xml' => array(
            'aliases' => array(
                'application.modules.routes.controllers.DefaultController',
            ),
            'param' => -1,
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
        'sitemapUsers1.xml' => array(
            'aliases' => array(
                'application.modules.userProfile.controllers.DefaultController',
            ),
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
//                    'sitemapRoutes2.xml' => array(
//                        'aliases' => array(
//                            'application.modules.routes.controllers.DefaultController',
//                        ),
//                        'param'=>2
//                    ),
//                    'sitemapRoutes3.xml' => array(
//                        'aliases' => array(
//                            'application.modules.routes.controllers.DefaultController',
//                        ),
//                        'param'=>3
//                    ),
//                    'sitemapRoutes4.xml' => array(
//                        'aliases' => array(
//                            'application.modules.routes.controllers.DefaultController',
//                        ),
//                        'param'=>4
//                    ),
        'sitemapAll.xml' => array(
            'aliases' => array(
                'application.modules.archive.controllers.DefaultController',
                'application.controllers.SiteController',
                'application.modules.services.modules.names.controllers.DefaultController',
                'application.modules.services.modules.childrenDiseases.controllers.DefaultController',
                'application.modules.calendar.controllers.DefaultController',
                'application.modules.services.modules.pregnancyWeight.controllers.DefaultController',
                'application.modules.services.modules.contractionsTime.controllers.DefaultController',
                'application.modules.services.modules.placentaThickness.controllers.DefaultController',
                'application.modules.services.modules.vaccineCalendar.controllers.DefaultController',
                'application.modules.services.modules.menstrualCycle.controllers.DefaultController',
                'application.modules.services.modules.babyBloodGroup.controllers.DefaultController',
                'application.modules.consultation.controllers.DefaultController',
            ),
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
        'sitemapRecipeBook.xml' => array(
            'aliases' => array(
                'application.modules.services.modules.recipeBook.controllers.DefaultController',
            ),
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
        'sitemapHoroscope.xml' => array(
            'aliases' => array(
                'application.modules.services.modules.horoscope.controllers.DefaultController',
                'application.modules.services.modules.horoscope.controllers.CompatibilityController',
            ),
            'cache' => array(
                'fileCache',
                /* кешируем на сутки */
                86400
            )
        ),
    ),
);
