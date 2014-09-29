<?php
$zodiacText = ($this->zodiac ? Horoscope::model()->zodiac_list2[array_search($this->zodiac, Horoscope::model()->zodiac_list_eng)] : '');
$this->widget('HMenu', array(
    'itemCssClass' => 'menu-link-simple_li',
    'htmlOptions' => array('class' => 'menu-link-simple_ul'),
    'items' => array(
        array(
            'label' => 'На сегодня',
            'url' => $this->getUrl(array('alias' => 'today')),
            'linkOptions' => array('class' => 'menu-link-simple_a'),
            'visible' => $this->alias !== 'today' || $this->period !== 'day',
        ),
        array(
            'label' => 'На завтра',
            'url' => $this->getUrl(array('alias' => 'tomorrow')),
            'linkOptions' => array('class' => 'menu-link-simple_a'),
            'visible' => $this->alias !== 'tomorrow',
        ),
        array(
            'label' => 'На месяц',
            'url' => $this->getUrl(array('period' => 'month', 'alias' => 'today')),
            'linkOptions' => array('class' => 'menu-link-simple_a'),
            'visible' => $this->period !== 'month' || $this->alias !== 'today',
        ),
        array('label' => 'На год',
            'url' => $this->getUrl(array('period' => 'year', 'alias' => 'today')),
            'linkOptions' => array('class' => 'menu-link-simple_a'),
            'visible' => $this->period !== 'year' || $this->alias !== 'today' || ($this->alias !== 'tomorrow' && $this->period !== 'year'),
        ),
        array(
            'label' => 'Гороскоп совместимости',
            'template' => '<span class="color-gray">+ &nbsp;</span>{menu}',
            'url' => array('/services/horoscope/compatibility/index'),
            'linkOptions' => array('class' => 'menu-link-simple_a'),
            'visible' => $this->zodiac == false,
        ),
        array(
            'label' => 'Гороскоп ' . $zodiacText . ' по дням',
            'template' => '<span class="color-gray">+ &nbsp;</span>{menu}',
            'url' => $this->getUrl(array('period' => 'month', 'alias' => false)),
            'linkOptions' => array('class' => 'menu-link-simple_a'),
            'visible' => $this->zodiac && $this->period == 'day' && ($this->alias == 'today' || $this->alias == 'tomorrow') || ($this->zodiac && $this->period == 'year'),
        ),
        array(
            'label' => 'Гороскоп ' . $zodiacText . ' по месяцам',
            'template' => '<span class="color-gray">+ &nbsp;</span>{menu}',
            'url' => $this->getUrl(array('period' => 'month', 'alias' => false)),
            'linkOptions' => array('class' => 'menu-link-simple_a'),
            'visible' => $this->zodiac && $this->period == 'month' && $this->alias == 'today',
        ),
    ),
));
?>
