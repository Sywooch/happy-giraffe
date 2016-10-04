<?php

use site\common\helpers\HStr;
use site\frontend\modules\posts\components\ReverseParser;

$parser = new ReverseParser($data->html);

if (! empty($parser->images))
{
    $photo = $parser->images[0]['photo'];
     
    $attachImage = \Yii::app()->thumbs->getThumb($photo, 'postImage');
    
    $imageUrl = !is_null($attachImage) ? $attachImage->getUrl() : FALSE;
}

?>

<article class="b-article clearfix b-article__list">
	<div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>
        <div class="b-article_header clearfix">
          	<div class="icons-meta">
          		<div class="c-list_item_btn">
          			<span class="c-list_item_btn__view">
          				<?php echo \Yii::app()->getModule('analytics')->visitsManager->getVisits($data->url); ?>
          			</span>
          			
            		<?php 
            		
            		echo CHtml::link(
                        $data->comments_count, 
            		    [
            		        $data->parsedUrl,
            		        '#' => 'commentsList'
        		        ],
            		    [
                            'class' => 'c-list_item_btn__comment margin-r0'
        		        ]
            		);
            		
            		?>
            	</div>
          	</div>
          	
          	<div class="float-l position-rel">
          	
                <?php 
                
                $this->widget('site\frontend\modules\posts\widgets\author\AuthorWidget', [
                    'post' => $data    
                ]); 
                
                ?>
                
            	<?php echo HHtml::timeTag($data, ['class' => 'tx-date']); ?>

            	<div class="b-subscribe">
            		
            		<?php 
            		
            		$userBlogSubscribeJSON = CJSON::encode([
            		    'userId'       => $data->user->id,
            		    'show'         => Yii::app()->user->id != $data->user->id,
            		    'isGuest'      => Yii::app()->user->isGuest,
            		    'isSubscribed' => UserBlogSubscription::isSubscribed(Yii::app()->user->id, $data->user->id),
            		    'count'        => (int) UserBlogSubscription::model()->subscribersCount($data->user->id)
            		]);
            		
            		$userBlogSubscribeJSON = str_replace('"', '\'', $userBlogSubscribeJSON);
            		
            		?>
            		
            		<user-blog-subscribe params="<?php echo $userBlogSubscribeJSON; ?>"></user-blog-subscribe>
            		
            	</div>
            	
          	</div>
        </div>
        <div class="b-article_t-list article_t-feed">
        	<?php 
            
        	echo CHtml::link($data->title, $data->parsedUrl, [
        	    'class' => 'b-article_t-a'
        	    
        	]);
        	
        	?>
    	</div>
    	
    	<?php if (isset($imageUrl)): ?>
  			
            <div class="b-album-cap">
          		<div class="b-album-cap_hold"><img src="<?php echo $imageUrl; ?>"></div>
            </div>
        
        <?php endif; ?>
        
        <?php if ($data->text): ?>
        
            <div class="b-article_content wysiwyg-content clearfix">
              	<p>
              	
              	<?php 

              	echo HStr::truncate($data->text, $maxTextLength, ''); 
              	
              	echo CHtml::link('', $data->parsedUrl, [
              	    'class' => 'ico-more'
              	]);
              	
              	?>
              	
              	</p>
            </div>
        
        <?php endif; ?>
        
  	</div>
</article>