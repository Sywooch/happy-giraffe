<?php $this->beginContent('//layouts/main'); ?>

<div id="cook-recipe">

    <?php if ($this->section == 1): ?>
        <div class="title title-recipes-1">
            <h1>Рецепты для <span>МУЛЬТИВАРОК</span></h1>
        </div>
    <?php endif; ?>

    <div class="clearfix">

        <div class="main">

            <div class="main-in">

                <?=$content?>

            </div>

        </div>

        <div class="side-left">

            <div class="recipe-search clearfix">
                <?=CHtml::beginForm('/cook/recipe/search', 'get')?>
                    <input type="text" name="text" value="<?php if (isset($_GET['text'])) echo urldecode($_GET['text']) ?>" class="text" placeholder="Поиск из <?=$count = CookRecipe::model()->cache(3600)->count() ?> <?=HDate::GenerateNoun(array('рецепта', 'рецептов', 'рецептов'), $count) ?>">
                    <input type="submit" value="" class="submit">
                <?=CHtml::endForm()?>
            </div>

            <div class="recipe-menu">
                <ul>
                    <li>
                        <a href="<?=(Yii::app()->user->isGuest) ? '#login' : $this->createUrl('/cook/recipe/form', array('section' => $this->section))?>"
                           data-theme="white-square"<?php if (Yii::app()->user->isGuest) echo 'class="fancy"'?>>
                                <span class="icon-holder">
                                    <i class="icon-cook-add"></i>
                                </span><span class="link-holder">
                                    <span class="link">Добавить рецепт</span>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=(Yii::app()->user->isGuest) ? '#login' : $this->createUrl('/cook/recipe/cookBook')?>"
                           data-theme="white-square"<?php if (Yii::app()->user->isGuest) echo 'class="fancy"'?>>
                                <span class="icon-holder">
                                    <i class="icon-cook-book"></i>
                                </span><span class="link-holder">
                                    <span class="link">Моя кулинарная книга</span>
                                    <span id="cookbook-recipe-count" class="pink"><?=$count = CookRecipe::userBookCount() ?> <?=HDate::GenerateNoun(array('рецепт', 'рецепта', 'рецептов'), $count) ?></span>
                                </span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="recipe-categories">
                <ul>
                    <?php foreach (CActiveRecord::model($this->modelName)->types as $id => $label): ?>
                        <li<?php if ($this->currentType == $id): ?> class="active"<?php endif; ?>>
                            <?php
                            $count = isset($this->counts[$id]) ? $this->counts[$id] : 0;
                            $text = '<span class="cook-cat-holder"><i class="icon-cook-cat icon-recipe-'.$id.'"></i></span>
                                <span class="cook-cat-frame">
                                    <span>'.$label.'</span>
                                    <span class="count">' . $count . '</span>
                                </span>';
                                    echo HHtml::link($text, $this->getTypeUrl($id), array('class'=>($this->currentType == $id)?'cook-cat active':'cook-cat'), true)
                            ?>
                            <img src="/images/recipe-categories-arrow.png" alt="" class="tale">
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="banner-box">
                    <?php $this->renderPartial('//_banner'); ?>
                </div>

            </div>

        </div>

    </div>

    <?php //$sql_stats = YII::app()->db->getStats();
    //echo $sql_stats[0] . ' запросов к БД, время выполнения запросов - ' . sprintf('%0.5f', $sql_stats[1]) . ' c.'; ?>

</div>

<?php $this->endContent(); ?>