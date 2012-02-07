<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://happyfront" data-via="<?php echo $options['via']; ?>">Tweet</a>
<?php
$js = '!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");';
Yii::app()->clientScript
    ->registerScript('fb_init', $js, CClientScript::POS_END);
?>