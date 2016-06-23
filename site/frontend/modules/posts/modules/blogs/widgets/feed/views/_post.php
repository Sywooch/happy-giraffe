<?php 

use site\common\helpers\HStr;
use site\frontend\modules\posts\components\ReverseParser;

$parser = new ReverseParser($data->html);

if (! empty($parser->images))
{
    $photo = $parser->images[0]['photo'];
    
    $imageUrl = \Yii::app()->thumbs->getThumb($photo, 'postImage')->getUrl();
}

?>

<article class="b-article clearfix b-article__list">
	<div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>
        <div class="b-article_header clearfix">
          	<div class="icons-meta">
          		<a href="#" class="icons-meta_comment">
          			<span class="icons-meta_tx"><?php echo $data->comments_count; ?></span>
      			</a>
            	<div class="icons-meta_view">
            		<span class="icons-meta_tx"><?php echo $data->views; ?></span>
        		</div>
          	</div>
          	<div class="float-l">
          	
                <?php 
                
                $this->widget('site\frontend\modules\posts\widgets\author\AuthorWidget', [
                    'post' => $data    
                ]); 
                
                ?>
                
            	<?php echo HHtml::timeTag($data, ['class' => 'tx-date']); ?>
            
            	<div class="b-subscribe">
         		 	<div class="btn btn-tiny green">Подписаться</div>
              		<div class="b-subscribe_tx">23</div>
            	</div>
          	</div>
        </div>
        <div class="b-article_t-list article_t-feed">
        	<a class="b-article_t-a article_t-feed"><?php echo $data->title; ?></a>
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
          	
          	echo CHtml::link('', $data->parsedUrl, ['class' => 'ico-more']);
          	
          	?>
          	
          	</p>
        </div>
        
        <?php endif; ?>
        
  	</div>
</article>