<?php
    $banners = array(
        'http://www.happy-giraffe.ru/names/',
        'http://www.happy-giraffe.ru/cook/',
        'http://www.happy-giraffe.ru/babySex/',
        'http://www.happy-giraffe.ru/cook/spices/'
    );
    $n = rand(0, 3);
?>
<?=CHtml::link(CHtml::image('/images/banners/' . $n . '.jpg'), $banners[$n])?>