<?php
$options = array();
foreach($this->options as $key => $value)
{
    if($key == 'url')
        $key = 'share_url';
    elseif($key == 'image')
        $key = 'imageurl';
    $options[$key] = $value;
}
?>
<p><a onclick="return Social.open('mr', this.href, 'Опубликовать ссылку в Mail.ru', 626, 436);" href="http://connect.mail.ru/share<?php echo $this->arrayToUrl($options); ?>">Поделиться с друзьями Моего Мира на Mail.ru</a></p>