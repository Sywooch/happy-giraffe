<div id="fb-root"></div>
<fb:like layout="button_count"></fb:like>
<?php
foreach($this->options as $key => $value)
{
    if($key == 'description')
    {
        $value = strip_tags($value);
    }
    Yii::app()->clientScript->registerMetaTag($value, null, null, array(
        'property' => 'og:' . $key
    ));
}
?>
<?php
$init_js = "(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = '//connect.facebook.net/ru_RU/all.js#xfbml=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));";
Yii::app()->clientScript
    ->registerScript('fb_init', $init_js, CClientScript::POS_HEAD)
?>