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
                        href="<?php echo $this->createUrl('/recipeBook/default/disease', array('url' => $disease->slug)) ?>"><?php
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
                        href="<?php echo $this->createUrl('/recipeBook/default/disease', array('url' => $disease->slug)) ?>"><?php
                        echo $disease->name ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <?php endforeach; ?>
            </div>
            <!-- .handbook_multi -->

        </div><!-- .handbook_alfa -->

        <div class="seo-text">
            <h1 class="summary-title">Книга народных рецептов от детских болезней</h1>

            <p>Детки в большинстве своем склонны к заболеваниям. Это объясняется тем, что родились они совсем недавно и не успели привыкнуть к этому миру. Там, в мамином животике, им было хорошо и уютно, а здесь, в реальном мире, им постоянно приходится сталкиваться с негативными явлениями, будь то природные факторы, такие как холод, сырость, слякоть, ветра, палящее солнце, или вредные вторжения – инфекции, микробы, вирусы. Взрослому многое нипочем, а ребенку, который впервые сталкивается с агрессивным воздействием окружающего мира, приходится тяжело, ведь его организм должен дать отпор всему. Но в этой борьбе организм крепнет, закаляется.</p>

            <p>Чтобы болезней было меньше и проходили они легче, важно знать особенности детского организма. Опытные врачи советуют начинать лечение с малого – с небольших доз, с легких препаратов, а еще лучше – с народных средств. Организм ребенка – новый, податливый, не засоренный шлаками и токсинами, потому даже слабые лекарственные средства будут существенно влиять на него. А если так – зачем пичкать ребенка новомодными препаратами? Конечно, их достоинства никто не отрицает, но знайте меру – применяйте их только в случае крайней необходимости.</p>
            <p>Дети болели всегда – и в давние времена, и 20 лет назад, и сейчас. В древности их не лечили теми препаратами, которые сейчас продаются в аптеке, – таких лекарств просто не было. Народ издавна применял методы лечения природными средствами и, отобрав наиболее эффективные, передавал их из поколения в поколение. И какое счастье, что мы сейчас имеем возможность узнать их, применить их – без вреда для детей, без особых финансовых затрат. Кстати, что касается новомодных препаратов – посмотрите их состав, ведь в основу рецептуры многих легли именно народные средства. Например, леденцы от кашля на основе меда, отхаркивающие растительные сиропы, травяные чаи, детская натуральная лечебная косметика, мази и кремы – вы думаете, кто их придумал? Наши предки! А современная фармакология воспользовалась рецептами и предлагает нам эти средства в удобной для применения форме.</p>
            <p>Но вы ведь не ленитесь готовить средства самостоятельно? Правда?</p>
            <p>Не знаете народные средства? А в этом вам как раз поможет наш сервис – Книга народных рецептов от детских болезней. Ищите по диагнозу и кликайте на него – вам откроются народные секреты лечения этого заболевания.</p>

            <p><i>Пользуйтесь нашим сервисом на здоровье!</i></p>
        </div>
