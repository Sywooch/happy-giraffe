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
                <form>
                    <input type="text" class="text" placeholder="Поиск из <?=$count = CookRecipe::model()->active()->count() ?> <?=HDate::GenerateNoun(array('рецепта', 'рецептов', 'рецептов'), $count) ?>">
                    <input type="submit" value="" class="submit">
                </form>
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
                        <a href="">
                                <span class="icon-holder">
                                    <i class="icon-cook-book"></i>
                                </span><span class="link-holder">
                                    <span class="link">Моя кулинарная книга</span>
                                    <span class="pink">25  рецептов</span>
                                </span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="recipe-categories">
                <ul>
                    <li<?php if ($this->currentType == null): ?> class="active"<?php endif; ?>>
                        <a class="cook-cat<?php if ($this->currentType == null): ?> active<?php endif; ?>"
                           href="<?=isset($_GET['text'])?
                            $this->createUrl('/cook/recipe/search', array('text'=>$_GET['text']))
                            :
                            $this->createUrl('/cook/recipe/index', array('section' => $this->section))?>">
                            <span class="cook-cat-holder">
                                <i class="icon-cook-cat icon-recipe-0"></i>
                            </span>
                            <span class="cook-cat-frame">
                                <span>Все рецепты</span>
                                <span class="count"><?=$this->counts[0]?></span>
                            </span>
                        </a>
                        <img src="/images/recipe-categories-arrow.png" alt="" class="tale">
                    </li>
                    <?php foreach (CActiveRecord::model($this->modelName)->types as $id => $label): ?>
                        <li<?php if ($this->currentType == $id): ?> class="active"<?php endif; ?>>
                            <a href="<?=isset($_GET['text'])?
                                $this->createUrl('/cook/recipe/search', array('type' => $id, 'text'=>$_GET['text']))
                                :
                                $this->createUrl('/cook/recipe/index', array('type' => $id, 'section' => $this->section))
                                ?>" class="cook-cat<?php if ($this->currentType == $id): ?> active<?php endif; ?>">
                                <span class="cook-cat-holder">
                                    <i class="icon-cook-cat icon-recipe-<?=$id ?>"></i>
                                </span>

                                <span class="cook-cat-frame">
                                    <span><?=$label?></span>
                                <span class="count"><?=isset($this->counts[$id])?$this->counts[$id]:0?></span>
                            </span>
                            </a>
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

</div>

<?php $this->endContent(); ?>