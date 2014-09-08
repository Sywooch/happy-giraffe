<div class="b-main_row b-main_row__green-dark">
    <div class="b-main_cont">
        <div class="b-main_col-wide color-white">
            <h2 class="heading-m textalign-c margin-0">Выберите возраст вашего ребенка</h2>
        </div>
    </div>
</div>
<!-- Календарь-->
<div class="b-main_row b-main_row__green-light">
    <div class="b-main_cont">
        <div class="calendar-serv calendar-serv__green">
            <div class="calendar-serv_row">
                <?php
                foreach ($periods as $i => $p)
                {
                    switch ($i)
                    {
                        case 0:
                            echo CHtml::tag('div', array('class' => 'calendar-serv_col-year'), '', false);
                            echo CHtml::tag('div', array('class' => 'calendar-serv_t'), 'Дети до года');
                            echo CHtml::tag('ul', array('class' => 'calendar-serv_ul clearfix'), '', false);
                            break;
                        case 1:
                            echo CHtml::closeTag('ul');
                            echo CHtml::tag('ul', array('class' => 'calendar-serv_ul calendar-serv_ul__column clearfix'), '', false);
                            break;
                        case 16:
                            echo CHtml::closeTag('ul');
                            echo CHtml::closeTag('div');
                            echo CHtml::tag('div', array('class' => 'calendar-serv_col-year'), '', false);
                            echo CHtml::tag('div', array('class' => 'calendar-serv_t'), 'Дети старше года');
                            echo CHtml::tag('ul', array('class' => 'calendar-serv_ul calendar-serv_ul__column clearfix'), '', false);
                            break;
                        case 22:
                            echo CHtml::closeTag('ul');
                            echo CHtml::tag('div', array('class' => 'calendar-serv_t'), 'Дошкольники');
                            echo CHtml::tag('ul', array('class' => 'calendar-serv_ul clearfix'), '', false);
                            break;
                        case 23:
                            echo CHtml::closeTag('ul');
                            echo CHtml::tag('div', array('class' => 'calendar-serv_t'), 'Младшие школьники');
                            echo CHtml::tag('ul', array('class' => 'calendar-serv_ul clearfix'), '', false);
                            break;
                        case 24:
                            echo CHtml::closeTag('ul');
                            echo CHtml::tag('div', array('class' => 'calendar-serv_t'), 'Средние школьники');
                            echo CHtml::tag('ul', array('class' => 'calendar-serv_ul clearfix'), '', false);
                            break;
                        case 25:
                            echo CHtml::closeTag('ul');
                            echo CHtml::tag('div', array('class' => 'calendar-serv_t'), 'Старшие школьники');
                            echo CHtml::tag('ul', array('class' => 'calendar-serv_ul clearfix'), '', false);
                            break;
                    }

                    $liClass = 'calendar-serv_li';
                    // if ($i > 21)
                    //     $liClass = 'calendar-serv_li';
                    // elseif ($i > 0)
                    //     $liClass = 'calendar-serv_li calendar-serv_li__50p';

                    $link = CHtml::link($p->title, $p->url, array('title' => $p->title, 'class' => 'calendar-serv_i'));
                    echo CHtml::tag('li', array('class' => $liClass), $link);

                    if ($i == 25)
                    {
                        echo CHtml::closeTag('ul');
                        echo CHtml::closeTag('div');
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Календарь -->