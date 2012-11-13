<?php
    $banners = array(
        'http://www.happy-giraffe.ru/names/',
        'http://www.happy-giraffe.ru/cook/',
        'http://www.happy-giraffe.ru/babySex/',
        'http://www.happy-giraffe.ru/cook/spices/',
        'http://www.happy-giraffe.ru/contest/2/',
    );
    $n = rand(0, count($banners) - 1);
?>
<?=CHtml::link(CHtml::image('/images/banners/' . $n . '.jpg'), $banners[$n])?>
