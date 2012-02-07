<?php
$params = array();
foreach($this->options as $key => $value)
{
    if($key == 'image')
        $key = 'imageurl';

    $params[$key] = $value;
}

if(!isset($params['url']))
    $params['url'] = urlencode(Yii::app()->createAbsoluteUrl(Yii::app()->request->pathInfo));
$href = 'http://connect.mail.ru/share?' . Yii::app()->urlManager->createPathInfo($params, '=', '&amp;');
?>
<a target="_blank" class="mrc__plugin_uber_like_button" href="<?php echo $href; ?>" data-mrc-config="{'type' : 'button', 'caption-mm' : '1', 'caption-ok' : '3', 'counter' : 'true', 'text' : 'true', 'width' : '100%'}">Нравится</a>
<script src="http://cdn.connect.mail.ru/js/loader.js" type="text/javascript" charset="UTF-8"></script>
