<?php
foreach($this->options as $key => $value)
{
    Yii::app()->clientScript->registerMetaTag($value, null, null, array(
        'property' => 'og:' . $key
    ));
}
?>
<p><a onclick="return Social.open('ok', this.href, 'Опубликовать ссылку в Одноклассниках', 800, 300);" rel="nofollow" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=<?php echo urlencode($this->options['url']); ?>">Поделиться с друзьями в Одноклассниках</a></p>