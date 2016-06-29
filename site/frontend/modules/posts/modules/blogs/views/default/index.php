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
    	<div class="mobile-ctrl_heading"><img src="/lite/images/new-design/images/blog-logo.png"><span>Блоги</span></div>
    	<div class="mobile-ctrl_btn"></div>
  	</div>
  
  	<div class="b-main_cont">
    	<div class="b-main_col-hold clearfix">
      		<div class="b-main_col-article"><?php $feedWidget->run(); ?></div>
      
        	<aside class="b-main_col-sidebar visible-md">
        		<ul class="sidebar-widget">
                	
                	<li class="sidebar-widget_item center-align">
                	
                	<?php if (Yii::app()->user->isGuest): ?>
                	
                    	<div class="btn bnt-massive green login-button" data-bind="follow: {}">Добавить в блог</div>
                        
                	<?php else: ?>
                	
                    	<div class="btn bnt-massive green">Добавить в блог</div>
                	
                	<?php endif; ?>
                  
                  	</li>
                  
                  	<li class="sidebar-widget_item">
                    
                    <?php 
                    
                    Yii::beginProfile('BlogesTopWidget'); 
                        
                        if ($this->beginCache('usersTopBlogs', [
                            'dependency' => [
                                'class' => 'system.caching.dependencies.CDbCacheDependency',
                                'sql'   => 'SELECT MAX(hotRate) FROM ' . Content::tableName()
                            ]
                        ]))
                        {
                            $this->widget('\site\frontend\modules\posts\modules\blogs\widgets\usersTop\UsersTopWidget', [
                                'labels' => [
                                    Label::LABEL_BLOG,
                                ],
                            ]); 
                            
                            $this->endCache();
                        }
                    
                    Yii::endProfile('BlogesTopWidget'); 
                    
                    ?>
                    
                 	</li>
                  	
        			<li class="sidebar-widget_item">
						
						<?php $this->widget('\site\frontend\modules\posts\modules\blogs\widgets\blogoefir\BlogoefirWidget'); ?>
                        
                  	</li>
                  	
                </ul>
              </aside>
    	</div>
  	</div>
</div>

<?php

$cs = Yii::app()->clientScript;

if ($cs->useAMD)
{
    $cs->registerAMD('blogVM', [
        'ko'       => 'knockout', 
        'ko_blogs' => 'ko_blogs'
    ]);
}
else
{
    $cs->registerPackage('ko_blogs');
}

?>