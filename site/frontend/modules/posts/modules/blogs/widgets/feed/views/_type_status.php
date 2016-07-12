<article class="b-article clearfix b-article__list b-article__user-status">
	<div class="b-article_cont clearfix">
    	<div class="b-article_header clearfix">
        	<div class="float-l position-rel w-300">
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
    	</div>
    	<div class="b-article_in clearfix"><?php echo $data->preview; ?></div>      
        <div class="b-article_like clearfix">
            <div class="article-also">
            	<div class="article-also_row like-control-hold"></div>
            </div>
        </div>
    </div>
</article>