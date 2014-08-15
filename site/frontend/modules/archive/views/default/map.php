<?php
/**
 * @var LiteController $this
 * @var CommunitySection[] $sections
 */
?>

<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <div class="b-main_col-article">
            <h1 class="heading-link-xxl">Карта сайта</h1>
        </div>
    </div>
    <div class="site-map clearfix">
        <div class="site-map_col">
            <h2 class="site-map_top site-map_top__club">Клубы</h2>
            <div class="clearfix">
                <div class="site-map_col-sub">
                    <?php $this->renderPartial('_section', array('section' => $sections[1], 'class' => 'pregnancy')); ?>
                    <?php $this->renderPartial('_section', array('section' => $sections[3], 'class' => 'beauty')); ?>
                </div>
                <div class="site-map_col-sub">
                    <?php $this->renderPartial('_section', array('section' => $sections[2], 'class' => 'home')); ?>
                    <?php $this->renderPartial('_section', array('section' => $sections[4], 'class' => 'husband-and-wife')); ?>
                    <?php $this->renderPartial('_section', array('section' => $sections[5], 'class' => 'hobby')); ?>
                    <?php $this->renderPartial('_section', array('section' => $sections[6], 'class' => 'holiday')); ?>
                </div>
            </div>
        </div>
        <div class="site-map_col">
            <h2 class="site-map_top site-map_top__services">Сервисы</h2>
            <div class="clearfix">
                <div class="site-map_col-sub">
                    <div class="site-map_section">
                        <div class="site-map_i">
                            <div class="site-map_i-tx">для беременных</div>
                        </div>
                        <ul class="menu-simple">
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/calendar/default/index', array('calendar' => 1))?>" class="a-light">Календарь беременности</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/names/default/index')?>" class="a-light">Выбор имени ребенка</a></li>
                            <li class="menu-simple_li"><a href="/babySex/" class="a-light">Определение пола ребенка </a>
                                <ul class="menu-simple">
                                    <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/babySex/default/china')?>" class="a-light">китайский метод</a></li>
                                    <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/babySex/default/japan')?>" class="a-light">японский метод</a></li>
                                    <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/babySex/default/bloodRefresh')?>" class="a-light">по датам рождения</a></li>
                                    <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/babySex/default/ovulation')?>" class="a-light">по овуляции</a></li>
                                    <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/babySex/default/blood')?>" class="a-light">по группе крови</a></li>
                                </ul>
                            </li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/pregnancyWeight/default/index')?>" class="a-light">Вес при беременности</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/test/default/view', array('slug' => 'pregnancy'))?>" class="a-light">Тест на беременность</a></li>
                            <li class="menu-simple_li"><a href="/placentaThickness/" class="a-light">Толщины плаценты</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/babyBloodGroup/default/index')?>" class="a-light disabled">Группа крови ребенка</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/contractionsTime/default/index')?>" class="a-light">Считаем схватки</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/maternityLeave/default/index')?>" class="a-light disabled">Когда уходить в декрет</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/hospitalBag/default/index')?>" class="a-light disabled">Сумка в роддом</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/birthDate/default/index')?>" class="a-light disabled">Определение даты родов</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/menstrualCycle/default/index')?>" class="a-light disabled">Женский календарь</a></li>
                        </ul>
                    </div>
                    <div class="site-map_section">
                        <div class="site-map_i">
                            <div class="site-map_i-tx">для мам</div>
                        </div>
                        <ul class="menu-simple">
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/calendar/default/index', array('calendar' => 0))?>" class="a-light">Календарь развития ребенка</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/test/default/view', array('slug' => 'pupok'))?>" class="a-light">В норме ли пупок у ребенка</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/vaccineCalendar/default/index')?>" class="a-light">Календарь прививок</a></li>
                            <li class="menu-simple_li"><a href="#" class="a-light">Бюджет малыша</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/test/default/view', array('slug' => 'prikorm'))?>" class="a-light">Тест. Готов ли ребенок к первому прикорму</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/test/default/view', array('slug' => 'hair-type'))?>" class="a-light">Тест определение типа волос</a></li>
                        </ul>
                    </div>
                    <div class="site-map_section">
                        <div class="site-map_i">
                            <div class="site-map_i-tx">по здоровью</div>
                        </div>
                        <ul class="menu-simple">
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/recipeBook/default/index')?>" class="a-light">Народные рецепты</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/childrenDiseases/default/index')?>" class="a-light">Справочник детских болезней</a></li>
                        </ul>
                    </div>
                </div>
                <div class="site-map_col-sub">
                    <div class="site-map_section">
                        <div class="site-map_i">
                            <div class="site-map_i-tx">для кулинаров</div>
                        </div>
                        <ul class="menu-simple">
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/cook/recipe/index')?>" class="a-light">Кулинарные рецепты</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/cook/recipe/index', array('section' => 1))?>" class="a-light">Рецепты для мультиварки</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/cook/calorisator/index')?>" class="a-light">Счетчик калорий</a></li>
                            <li class="menu-simple_li"><a href="/cook/converter/" class="a-light">Калькулятор мер и весов</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/cook/spices/index')?>" class="a-light disabled">Приправы и специи</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/cook/choose/index')?>" class="a-light disabled">Как выбрать продукты</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/cook/decor/index')?>" class="a-light disabled">Оформление блюд</a></li>
                        </ul>
                    </div>
                    <div class="site-map_section">
                        <div class="site-map_i">
                            <div class="site-map_i-tx">для ремонта</div>
                        </div>
                        <ul class="menu-simple">
                            <li class="menu-simple_li"><a href="/repair/paint/" class="a-light disabled">Расчет объема краски</a></li>
                            <li class="menu-simple_li"><a href="/repair/tile/" class="a-light disabled">Расчет плитки для ванной</a></li>
                            <li class="menu-simple_li"><a href="/repair/suspendedCeiling/" class="a-light disabled">Расчет подвесного потолка</a></li>
                            <li class="menu-simple_li"><a href="/repair/wallpapers/index/" class="a-light disabled">Расчет количества обоев</a></li>
                            <li class="menu-simple_li"><a href="/repair/flooring/index/" class="a-light disabled">Расчет напольного покрытия</a></li>
                        </ul>
                    </div>
                    <div class="site-map_section">
                        <div class="site-map_i">
                            <div class="site-map_i-tx">для рукодельниц</div>
                        </div>
                        <ul class="menu-simple">
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/sewing/default/fabricCalculator')?>" class="a-light disabled">Калькулятор ткани</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/sewing/default/loopCalculator')?>" class="a-light disabled">Калькулятор петель</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/sewing/default/embroideryCost')?>" class="a-light disabled">Расчет стоимости вышивки</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/sewing/default/threadCalculation')?>" class="a-light disabled">Расчет ниток</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/services/sewing/default/yarn/calculator')?>" class="a-light disabled">Расчет пряжи</a></li>
                        </ul>
                    </div>
                    <div class="site-map_section">
                        <div class="site-map_i">
                            <div class="site-map_i-tx">для автолюбителей</div>
                        </div>
                        <ul class="menu-simple">
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/routes/default/index')?>" class="a-light">Маршруты</a></li>
                        </ul>
                    </div>
                    <div class="site-map_section">
                        <div class="site-map_i">
                            <div class="site-map_i-tx">для всех</div>
                        </div>
                        <ul class="menu-simple">
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/horoscope/default/index')?>" class="a-light">Гороскопы</a></li>
                            <li class="menu-simple_li"><a href="#" class="a-light">Тест. Определение типа волос</a></li>
                            <li class="menu-simple_li"><a href="<?=$this->createUrl('/archive/default/index')?>" class="a-light">Календарь записей</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>