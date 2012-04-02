<?php
$options = array();
foreach ($this->options as $key => $value)
{
    if ($key == 'url')
        $key = 'share_url';
    elseif ($key == 'image')
        $key = 'imageurl';
    $options[$key] = $value;
}
?>
<a
    onclick="return Social.open('mr', this.href, 'mailru', 626, 436, this);"
    href="http://connect.mail.ru/share<?php echo $this->arrayToUrl($options); ?>"
    title="Поделиться с друзьями Моего Мира на Mail.ru"
    rel="nofollow"
    class="btn-icon mm"></a>
<div class="count"><?php echo Rating::model()->countByEntity($this->model, 'mr'); ?></div>