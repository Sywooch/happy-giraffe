<?php
foreach($this->options as $key => $value)
{
    Yii::app()->clientScript->registerMetaTag($value, null, null, array(
        'property' => 'og:' . $key
    ));
}
?>
<a onclick="return Social.open('fb', this.href, 'facebook', 800, 300, this);"
   href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($this->options['url']); ?>"
   title="Опубликовать ссылку во Facebook"
   rel="nofollow"
   class="btn-icon fb"></a>
<div class="count"><?php echo Rating::model()->countByEntity($this->model, 'fb'); ?></div>