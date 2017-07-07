<?php

use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

/**
 * @var $this       \site\frontend\modules\posts\modules\blogs\controllers\DefaultController
 * @var $feedWidget \site\frontend\modules\posts\modules\blogs\widgets\feed\FeedWidget
 * @var $cs         \CClientScript
 */

$this->pageTitle = 'Блоги';

$breadcrumbs = [
    'Главная' => ['/site/index'],
    $this->pageTitle
];

?>

<div class="b-main blog-homepage">

	<div class="b-breadcrumbs">

  	<?php

  	$this->widget('zii.widgets.CBreadcrumbs', [
        'links'                => $breadcrumbs,
        'tagName'              => 'ul',
        'homeLink'             => FALSE,
        'separator'            => '',
        'activeLinkTemplate'   => '<li><a href="{url}">{label}</a></li>',
        'inactiveLinkTemplate' => '<li>{label}</li>',
    ]);

  	?>

  	</div>

  	<?php $feedWidget->getMenuWidget()->run(); ?>

  	<div class="mobile-ctrl">
    	<div class="mobile-ctrl_heading">
    		<img src="/lite/images/new-design/images/blog-logo.png">
    		<span>Блоги</span>
		</div>
            <!--     	<div class="mobile-ctrl_btn"></div> -->
			<?php if (Yii::app()->user->isGuest): ?>

            	<div class="mobile-ctrl_btn login-button" data-bind="follow: {}"></div>


        	<?php else: ?>

            	<a href="/blogs/add-form" class="mobile-ctrl_btn fancy"></a>

        	<?php endif; ?>
  	</div>

  	<div class="b-main_cont b-main_cont-xs">
    	<div class="b-main_col-hold clearfix">
      		<div class="b-main_col-article"><?php $feedWidget->run(); ?></div>

        	<aside class="b-main_col-sidebar visible-md">
        		<ul class="sidebar-widget">

                	<li class="sidebar-widget_item center-align">

                	<?php if (Yii::app()->user->isGuest): ?>

                    	<div class="btn bnt-massive green login-button" data-bind="follow: {}">Добавить в блог</div>

                	<?php else: ?>

                    	<a href="/blogs/add-form" class="btn bnt-massive green is-need-loading">Добавить в блог</a>

                	<?php endif; ?>

                  	</li>

                  	<li class="sidebar-widget_item">

                    <?php

                    Yii::beginProfile('BlogersTopWidget');

                        if ($this->beginCache('usersTopBlogs', [
                            'duration' => 3600
                        ]))
                        {
                            $this->widget('\site\frontend\modules\posts\modules\blogs\widgets\usersTop\UsersTopWidget', [
                                'labels' => [
                                    Label::LABEL_BLOG,
                                ],
                            ]);

                            $this->endCache();
                        }

                    Yii::endProfile('BlogersTopWidget');

                    ?>

                 	</li>

        			<li class="sidebar-widget_item">

						<?php // $this->widget('\site\frontend\modules\posts\modules\blogs\widgets\blogoefir\BlogoefirWidget'); ?>

                  	</li>

                </ul>
              </aside>
    	</div>
  	</div>
</div>
