<div class="b-widget-wrapper b-widget-wrapper_theme b-widget-wrapper_border">
	<div class="b-widget-header">
    	<div class="b-widget-header__title b-widget-header__title_live">Блогоэфир</div>
	</div>
  	<div class="b-widget-content">
        <ul class="b-widget-content__list">
        
        	<?php foreach ($rows as $row): ?>
        		
        	<li class="b-widget-content__item">
            	<div class="b-widget-content__ava">
            		<img src="<?php echo $row->user->avatarUrl; ?>" alt="">
        		</div>
        		
        		<?php
        		
        		echo CHtml::link($row->user->fullName, $row->user->profileUrl, [
        		    'class' => 'b-widget-content__username'
        		]);
        		
        		?>
            	
            	<div class="b-widget-content__date">
            		<?php echo HHtml::timeTag($row, ['class' => '']); ?>
            	</div>
            	
                <!--             	
                <div class="b-widget-content__date">30 минут назад</div> 
                -->
                
            	<div class="b-widget-content__title">
            		<?php 
            		
            		echo CHtml::link($row->title, $row->parsedUrl, [
            		    'class' => 'b-widget-content__link'
            		]);
            		
            		?>
        		</div>
      		</li>
        	
        	<?php endforeach; ?>
        	
        	<?php if (FALSE): ?>
        	
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
          	
          	<?php endif; ?>
          	
        </ul>
    	<div class="b-widget-controls">
      		<div class="b-widget-controls__left"></div>
      		<div class="b-widget-controls__right"></div>
    	</div>
  	</div>
</div>