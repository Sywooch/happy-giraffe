<?php

$this->widget('HMenu', array(
    'itemCssClass' => 'menu-link-simple_li',
    'htmlOptions' => array('class' => 'menu-link-simple_ul'),
    'items' => array(
        array(
            'label' => 'На сегодня',
            'url' => $this->getUrl(array('alias' => 'today')),
            'linkOptions' => array('class' => 'menu-link-simple_a'),
            'visible' => $this->alias !== 'today',
        ),
        array(
            'label' => 'На завтра',
            'url' => $this->getUrl(array('alias' => 'tomorrow')),
            'linkOptions' => array('class' => 'menu-link-simple_a'),
            'visible' => $this->alias !== 'tomorrow',
        ),
        array(
            'label' => 'На месяц',
            'url' => $this->getUrl(array('period' => 'month')),
            'linkOptions' => array('class' => 'menu-link-simple_a'),
            'visible' => $this->period !== 'month',
        ),
        array('label' => 'На год',
            'url' => $this->getUrl(array('period' => 'year')),
            'linkOptions' => array('class' => 'menu-link-simple_a'),
            'visible' => $this->period !== 'year',
        ),
        array(
            'label' => 'Гороскоп совместимости',
            'template' => '<span class="color-gray">+ &nbsp;</span>{menu}',
            'url' => array('/services/horoscope/compatibility/index'),
            'linkOptions' => array('class' => 'menu-link-simple_a'),
        ),
    ),
));
?>
