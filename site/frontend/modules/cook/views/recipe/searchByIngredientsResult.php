<?php if ($recipes): ?>
    <div class="result-title clearfix">

        <div class="filter">
            Показывать
            &nbsp;
            <span class="chzn-v2">
                <?=CHtml::dropDownList('type', $type, CActiveRecord::model($this->modelName)->types, array('prompt' => 'Все блюда', 'class' => 'chzn'))?>
            </span>
        </div>

        <div class="count">
            Найдено рецептов
            <span><?=count($recipes)?></span>
        </div>

    </div>

    <div class="recipe-list">

        <ul class="scroll">
            <?php foreach ($recipes as $r): ?>
                <li>
                    <div class="item-title"><?=CHtml::link($r->title, $r->url)?></div>
                    <div class="content">
                        <?=$r->preview?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>
<?php else: ?>
    <div class="result-title clearfix">

        <div class="filter">
            Показывать
            &nbsp;
            <span class="chzn-v2">
                <?=CHtml::dropDownList('type', $type, CActiveRecord::model($this->modelName)->types, array('prompt' => 'Все блюда', 'class' => 'chzn'))?>
            </span>
        </div>

    </div>

    <div class="arrow"></div>

    <div class="text">

        <img src="/images/cook_recipe_search_spoon.gif" /><br/>

        <span>Найдено 0 рецептов</span>

        Попробуйте изменить состав ингредиентов

    </div>
<?php endif; ?>