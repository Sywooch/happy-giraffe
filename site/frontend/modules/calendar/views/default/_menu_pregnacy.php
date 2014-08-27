<div class="b-main_row b-main_row__pink">
    <div class="b-main_cont">
        <div class="b-main_col-wide color-white">
            <h2 class="heading-m textalign-c margin-0">Выберите период вашей беременности</h2>
        </div>
    </div>
</div>
<!-- Календарь -->
<div class="b-main_row b-main_row__pink-light">
    <div class="b-main_cont">
        <div class="calendar-serv calendar-serv__pink">
            <?php
            foreach ($periods as $i => $p)
            {
                $liClass = 'calendar-serv_li calendar-serv_li__50p';
                $linkClass = 'calendar-serv_i';
                $li = true;
                switch ($i)
                {
                    case 0:
                        echo CHtml::tag('div', array('class' => 'calendar-serv_row textalign-c'), '', false);
                        $linkClass = 'calendar-serv_i w-160';
                        $li = false;
                        break;
                    case 1:
                        echo CHtml::closeTag('div');
                        echo CHtml::tag('div', array('class' => 'calendar-serv_row'), '', false);
                        echo CHtml::tag('div', array('class' => 'calendar-serv_col-trimester'), '', false);
                        echo CHtml::tag('div', array('class' => 'calendar-serv_t'), '1 триместр');
                        echo CHtml::tag('ul', array('class' => 'calendar-serv_ul clearfix'), '', false);
                        break;
                    case 14:
                        echo CHtml::closeTag('ul');
                        echo CHtml::closeTag('div');
                        echo CHtml::tag('div', array('class' => 'calendar-serv_col-trimester'), '', false);
                        echo CHtml::tag('div', array('class' => 'calendar-serv_t'), '2 триместр');
                        echo CHtml::tag('ul', array('class' => 'calendar-serv_ul clearfix'), '', false);
                        break;
                    case 27:
                        echo CHtml::closeTag('ul');
                        echo CHtml::closeTag('div');
                        echo CHtml::tag('div', array('class' => 'calendar-serv_col-trimester'), '', false);
                        echo CHtml::tag('div', array('class' => 'calendar-serv_t'), '3 триместр');
                        echo CHtml::tag('ul', array('class' => 'calendar-serv_ul clearfix'), '', false);
                        break;
                    case 41:
                        echo CHtml::closeTag('ul');
                        echo CHtml::closeTag('div');
                        echo CHtml::closeTag('div');
                        echo CHtml::closeTag('div');
                        echo CHtml::tag('div', array('class' => 'calendar-serv_row textalign-c'), '', false);
                        $li = false;
                        $linkClass = 'calendar-serv_i w-135';
                        break;
                }
                
                $linkText = $p->title;
                
                if ($i > 0 && $i < 41)
                    $linkText = str_replace(' неделя', ' <span class="calendar-serv_desc-hide">неделя</span>', $p->title);

                $link = CHtml::link($linkText, $p->url, array('title' => $p->title, 'class' => $linkClass));
                if ($li)
                    echo CHtml::tag('li', array('class' => $liClass), $link);
                else
                    echo $link;

                if ($i == 41)
                {
                    echo CHtml::closeTag('div');
                }
            }
            ?>
        </div>
    </div>
</div>
<!-- Календарь -->