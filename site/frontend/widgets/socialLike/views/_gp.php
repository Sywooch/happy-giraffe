<!-- Поместите этот тег туда, где должна отображаться кнопка +1. -->
<g:plusone></g:plusone>

<?php
foreach($this->options as $key => $value)
{
    Yii::app()->clientScript->registerMetaTag($value, null, null, array(
        'property' => 'og:' . $key
    ));
}
?>

<!-- Поместите этот вызов функции отображения в соответствующее место. -->
<script type="text/javascript">
  window.___gcfg = {lang: 'ru'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>