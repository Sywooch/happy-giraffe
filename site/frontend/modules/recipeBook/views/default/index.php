<?php Yii::app()->clientScript->registerScript('children-dizzy', "
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
<?php Yii::app()->clientScript->registerScript('chilred-dizzy-2', "
        $('#disease-alphabet').click(function () {
            if ($(this).parent('li').hasClass('current_t')) {
                $('#popup').hide();
                $(this).parent('li').removeClass('current_t');
            } else{
                $('#disease-type').parent('li').removeClass('current_t');
                $.ajax({
                    url:'" . Yii::app()->createUrl("/childrenDiseases/default/getAlphabetList") . "',
                    type:'POST',
                    success:function (data) {
                        $('#popup').html(data);
                        $('#popup').show();
                        $(this).parent('li').addClass('current_t');
                    },
                    context:$(this)
                });
            }
            return false;
        });

        $('#disease-type').click(function () {
            if ($(this).parent('li').hasClass('current_t')) {
                $('#popup').hide();
                $(this).parent('li').removeClass('current_t');
            } else{
                $('#disease-alphabet').parent('li').removeClass('current_t');
                $.ajax({
                    url:'" . Yii::app()->createUrl("/childrenDiseases/default/getCategoryList") . "',
                    type:'POST',
                    success:function (data) {
                        $('#popup').html(data);
                        $('#popup').show();
                        $(this).parent('li').addClass('current_t');
                    },
                    context:$(this)
                });
            }
            return false;
        });
    "); ?>
<div id="baby">

    <div class="content-box clearfix">
        <div class="baby_recipes_service">
            <ul class="handbook_changes_u">
                <li class="current_t"><a href="#">Главная</a></li>
                <li><a id="disease-alphabet" href="#"><span>Болезни по алфавиту</span></a></li>
                <li><a id="disease-type" href="#"><span>Болезни по типу</span></a></li>
            </ul>
            <div class="handbook_alfa_popup" id="popup" style="display: none;">

            </div>
        </div>
        <!-- .baby_recipes_service -->
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

        <div class="about_recipes_book">
            <h1>Как пользоваться нашей книгой народных рецептов</h1>

            <p>Менструальный цикл – это не просто кровотечение по расписанию, это перестройка всего организма с одной
                единственной целью – дать начало новой человеческой жизни.</p>

            <p>Традиционно первым днём менструального цикла является начало менструации. В это время матка отторгает
                непригодившийся внутренний слой – эндометрий, освобождая место для роста нового.</p>

            <p>В это же время под контролем гипоталамуса в гипофизе вырабатываются гормоны, стимулирующие созревание
                яйцеклетки в яичнике женщины, начинает повышаться уровень женских половых гормонов – эстрогенов.</p>

            <p>После окончания менструации продолжает нарастать уровень эстрогенов, и к середине цикла он достигает
                максимума. Слизь, закрывающая канал шейки матки, становится жидкой, создавая условия для свободного
                проникновения в полость матки сперматозоидов, а созревшая яйцеклетка покидает фолликул яичника и
                отправляется навстречу сперматозоиду. В момент выхода яйцеклетки из яичника отмечается повышение
                температуры тела женщины примерно на полградуса.</p>

            <p>Если яйцеклетка не встретилась со сперматозоидом и беременность не состоялась, уровень эстрогенов резко
                снижается. Фолликул, который покинула яйцеклетка, становится жёлтым телом и начинает вырабатывать
                прогестерон.</p>

            <p>Через несколько дней жёлтое тело начинает уменьшаться в размерах, снижается его активность, параллельно
                уменьшается выработка прогестерона. В этот период у многих женщин развивается так называемый ПМС
                (предменструальный синдром), который проявляется резкой сменой настроения, раздражительностью,
                плаксивостью, депрессиями, появлением отёчности лица, нагрубанием молочных желез. Когда уровень
                прогестерона достигает минимума, температура тела женщины понижается на полградуса и начинается
                менструальное кровотечение, то есть следующий менструальный цикл.</p>

            <p>Длительность менструального цикла у каждой женщины своя – от 21 до 35 суток, но она постоянна. То есть
                если цикл составляет 28 дней в этом месяце, то и в следующем будет таким, и через полгода тоже. Многие
                женщины ведут календари, в которых отмечают начало и продолжительность каждой менструации.</p>

            <p>Наш сервис предлагает завести себе электронный календарь, при помощи которого можно:</p>
            <ul>
                <li>
                    <ins>*</ins>
                    составить индивидуальный график менструального цикла за любой промежуток времени (при этом все
                    данные сохраняются, и их легко проанализировать);
                </li>
                <li>
                    <ins>*</ins>
                    узнать вероятную дату овуляции;
                </li>
                <li>
                    <ins>*</ins>
                    определить опасные и безопасные дни для наступления беременности;
                </li>
                <li>
                    <ins>*</ins>
                    прогнозировать начало ПМС и вовремя принять меры.
                </li>
            </ul>
            <p>Для этого нужно ввести все данные в специальные окошки. Нажать кнопку «рассчитать» и посмотреть
                результат, который наглядно покажет именно ваш менструальный цикл со всеми его особенностями, что,
                несомненно, поможет правильно спланировать свою личную жизнь. Кстати, вам не придётся повторять ввод
                данных – ваш женский календарь сохранится в вашем личном кабинете и будет постоянно доступен для
                пользования и занесения данных нового месяца.</p>
        </div>
        <!-- .about_recipes_book -->

    </div>

</div>
<div class="push"></div>