<?php
foreach($this->options as $key => $value)
{
    Yii::app()->clientScript->registerMetaTag($value, null, null, array(
        'property' => 'og:' . $key
    ));
}
?>
<a onclick="return Social.open('ok', this.href, 'ok', 800, 300, this);"
   href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=<?php echo urlencode($this->options['url']); ?>"
   rel="nofollow"
   title="Поделиться с друзьями в Одноклассниках"
   class="btn-icon ok"></a>
<div class="count"><?php echo Rating::model()->countByEntity($this->model, 'ok'); ?></div>