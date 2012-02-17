<?php
foreach($this->options as $key => $value)
{
    Yii::app()->clientScript->registerMetaTag($value, null, null, array(
        'property' => 'og:' . $key
    ));
}
?>
<p><a onclick="return Social.open('fb', this.href, 'Опубликовать ссылку в Facebook', 800, 300);" title="Опубликовать ссылку в Facebook" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($this->options['url']); ?>">Опубликовать ссылку во Facebook</a></p>