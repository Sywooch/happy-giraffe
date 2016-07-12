<?php

/**
 * @var \site\frontend\modules\posts\modules\blogs\widgets\usersTop\UsersTopWidget $this
 * @var array $rows
 */

?>

<div class="b-widget-wrapper b-widget-wrapper_people b-widget-wrapper_border b-widget-wrapper_bloger">
 	<div class="b-widget-header">
    	<div class="b-widget-header__title">Блогер <?php echo $this->getMonthName(); ?></div>
  	</div>
  	<div class="b-widget-content">
    	<ul class="b-widget-content__list">
    
      	<?php foreach ($rows as $i => $row): ?>
      	
    	<li class="b-widget-content__item">
        	<div class="b-widget-content__number"><?php echo ($i + 1); ?></div>
        	
        	<div class="b-widget-content__ava">
        		<img src="<?php echo $row['user']->avatarUrl; ?>" alt="">
        	</div>
        	
        	<div class="b-widget-content__name">
        		<a href="<?php echo $row['user']->profileUrl; ?>" class="b-widget-content__link"><?php echo $row['user']->fullName; ?></a>
    		</div>
    		
        	<div class="b-widget-content__rating"><?php echo intval($row['score']); ?><span>баллов</span></div>
    	</li>
    	
    	<?php endforeach; ?>
    	
		</ul>
  	</div>
</div>