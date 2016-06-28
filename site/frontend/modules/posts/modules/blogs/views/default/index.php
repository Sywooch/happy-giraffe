<?php 

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
                    
                    Yii::beginProfile('UsersTopWidget'); 
                        
                        $this->beginCache('usersTopBlogs', ['duration' => 1000]);
                    
                            $this->widget('\site\frontend\modules\posts\modules\blogs\widgets\usersTop\UsersTopWidget', [
                                'labels' => [
                                    \site\frontend\modules\posts\models\Label::LABEL_BLOG,
                                ],
                            ]); 
                            
                        $this->endCache();
                    
                    Yii::endProfile('UsersTopWidget'); 
                    
                    ?>
                    
                 	</li>
                  	
                  	<?php $this->widget('\site\frontend\modules\posts\modules\blogs\widgets\blogoefir\BlogoefirWidget'); ?>
                  	
        			<li class="sidebar-widget_item">
        				
        				<?php if (FALSE): ?>
        				
                        <div class="b-widget-wrapper b-widget-wrapper_theme b-widget-wrapper_border">
                      		<div class="b-widget-header">
                            	<div class="b-widget-header__title b-widget-header__title_live">Блогоэфир</div>
                      		</div>
                          	<div class="b-widget-content">
                                <ul class="b-widget-content__list">
                              		<li class="b-widget-content__item">
                                    	<div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div><a href="#" class="b-widget-content__username">Ольга Емельянова</a>
                                    	<div class="b-widget-content__date">30 минут назад</div>
                                    	<div class="b-widget-content__title"><a href="#" class="b-widget-content__link">Что вы ели при токсиккозе? Не могу больше пить чай с бубликами</a></div>
                              		</li>
                                  	<li class="b-widget-content__item">
                                    	<div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div><a href="#" class="b-widget-content__username">Ольга Емельянова</a>
                                    	<div class="b-widget-content__date">30 минут назад</div>
                                    	<div class="b-widget-content__title"><a href="#" class="b-widget-content__link">Что вы ели при токсиккозе? Не могу больше пить чай с бубликами</a></div>
                                  	</li>
                                  	<li class="b-widget-content__item">
                                    	<div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div><a href="#" class="b-widget-content__username">Ольга Емельянова</a>
                                    	<div class="b-widget-content__date">30 минут назад</div>
                                    	<div class="b-widget-content__title"><a href="#" class="b-widget-content__link">Что вы ели при токсиккозе? Не могу больше пить чай с бубликами</a></div>
                                  	</li>
                                  	<li class="b-widget-content__item">
                                    	<div class="b-widget-content__ava"><img src="/images/icons/ava.jpg" alt=""></div><a href="#" class="b-widget-content__username">Ольга Емельянова</a>
                                    	<div class="b-widget-content__date">30 минут назад</div>
                                    	<div class="b-widget-content__title"><a href="#" class="b-widget-content__link">Что вы ели при токсиккозе? Не могу больше пить чай с бубликами</a></div>
                                  	</li>
                                </ul>
                            	<div class="b-widget-controls">
                              		<div class="b-widget-controls__left"></div>
                              		<div class="b-widget-controls__right"></div>
                            	</div>
                          	</div>
                        </div>
                        
                        <?php endif; ?>
                        
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