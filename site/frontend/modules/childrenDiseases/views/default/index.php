<?php Yii::app()->clientScript->registerScript('children-dizzy',"
        $('#disease-alphabet2 a').click(function () {
            if (!$(this).hasClass('current_t')) {
                $('#category-list').hide();
                $('#alphabet-list').show();
                $('.sortable_u li').removeClass('current_t');
                $(this).parent('li').addClass('current_t');
            }
            return false;
        });

        $('#disease-type2 a').click(function () {
            if (!$(this).hasClass('current_t')) {
                $('#category-list').show();
                $('#alphabet-list').hide();
                $('.sortable_u li').removeClass('current_t');
                $(this).parent('li').addClass('current_t');
            }
            return false;
        });
"); ?>
<div class="handbook_alfa">
    <span class="handbook_title">Выберите болезнь</span>
    <ul class="sortable_u">
        <li id="disease-alphabet2" class="current_t"><a href="#"><span>По алфавиту</span></a></li>
        <li>|</li>
        <li id="disease-type2"><a href="#"><span>По типу заболевания</span></a></li>
    </ul>
    <div class="clear"></div>
    <!-- .clear -->
    <div id="alphabet-list" class="handbook_multi">
        <?php foreach ($alphabetList as $letter => $diseases): ?>
        <ul class="handbook_list">
            <li><span><?php echo strtoupper($letter) ?></span></li>
            <?php foreach ($diseases as $disease): ?>
            <li><a
                href="<?php echo $this->createUrl('/childrenDiseases/default/view', array('url' => $disease->slug)) ?>"><?php
                echo $disease->name ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php endforeach; ?>
    </div>
    <!-- .handbook_multi -->

    <div id="category-list" class="handbook_multi" style="display: none;">
        <?php foreach ($categoryList as $category => $diseases): ?>
        <ul class="handbook_list">
            <li><span><?php echo strtoupper($category) ?></span></li>
            <?php foreach ($diseases as $disease): ?>
            <li><a
                href="<?php echo $this->createUrl('/childrenDiseases/default/view', array('url' => $disease->slug)) ?>"><?php
                echo $disease->name ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php endforeach; ?>
    </div>
    <!-- .handbook_multi -->

</div><!-- .handbook_alfa -->
<p class="p40">Менструальный цикл – это не просто кровотечение по расписанию, это перестройка всего организма с одной
    единственной целью – дать начало новой человеческой жизни.Для этого нужно ввести все данные в специальные окошки.
    Нажать кнопку «рассчитать» и посмотреть результат, который наглядно покажет именно ваш менструальный цикл со всеми
    его особенностями, что, несомненно, поможет правильно спланировать свою личную жизнь. Кстати, вам не придётся
    повторять ввод данных – ваш женский календарь сохранится в вашем личном кабинете и будет постоянно доступен для
    пользования и занесения данных нового месяца.</p>