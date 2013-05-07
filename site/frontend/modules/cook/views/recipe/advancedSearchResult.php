<?php if ($recipes): ?>
    <div class="result-title clearfix">

        <div class="count">
            Найдено рецептов
            <span><?=$recipes->totalItemCount?></span>
        </div>

    </div>

    <div class="recipe-list">

        <?php
            $this->widget('zii.widgets.CListView', array(
                'cssFile'=>false,
                'id' => 'recipesList',
                'dataProvider' => $recipes,
                'itemView' => '_search_result',
                'itemsTagName' => 'ul',
                'template' => "{items}\n{pager}",
                'pager' => array(
                    'header' => '',
                    'class' => 'ext.infiniteScroll.IasPager',
                    'rowSelector' => 'li',
                    'listViewId' => 'recipesList',
                    'options' => array(
                        'loader' => 'Загрузка...',
                        'scrollContainer' => new CJavaScriptExpression('$(\'#recipesList .items\')'),
                    ),
                ),
            ));
        ?>

    </div>
<?php else: ?>
    <div class="arrow"></div>

    <div class="text">

        <img src="/images/cook_recipe_search_spoon.gif" /><br/>

        <span>Найдено 0 рецептов</span>

        Попробуйте изменить состав параметров

    </div>
<?php endif; ?>