<!-- Клубы-->
<div class="homepage_row">
    <div class="homepage-clubs">
        <?php if (Yii::app()->vm->getVersion() == VersionManager::VERSION_DESKTOP): ?>
          <div class="homepage_title"> Мы здесь общаемся<br>на различные семейные темы </div>
        <?php else: ?>
          <div class="homepage_title"> Наши клубы </div>
        <?php endif; ?>
        <div class="homepage-clubs_hold">
            <!-- collection-->
            <div class="homepage-clubs_collection homepage-clubs_collection__1">
                <div class="homepage-clubs_title-hold">
                    <div class="homepage-clubs_title">Муж и жена</div>
                </div>
                <ul class="homepage-clubs_ul">
                    <li class="homepage-clubs_li"><a href="/wedding/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__14"></div>
                            </div>
                            <div class="homepage-clubs_tx">Свадьба</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(14)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/relations/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__15"></div>
                            </div>
                            <div class="homepage-clubs_tx">Отношение в семье </div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(15)?></div></a></li>
                </ul>
            </div>
            <!-- collection-->
            <div class="homepage-clubs_collection homepage-clubs_collection__2">
                <div class="homepage-clubs_title-hold">
                    <div class="homepage-clubs_title">Беременность и дети</div>
                </div>
                <ul class="homepage-clubs_ul">
                    <li class="homepage-clubs_li"><a href="/planning-pregnancy/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__1"></div>
                            </div>
                            <div class="homepage-clubs_tx">Планирование</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(1)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/pregnancy-and-birth/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__2"></div>
                            </div>
                            <div class="homepage-clubs_tx">Беременность и роды</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(2)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/babies/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__3"></div>
                            </div>
                            <div class="homepage-clubs_tx">Дети до года</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(3)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/kids/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__4"></div>
                            </div>
                            <div class="homepage-clubs_tx">Дети старше года</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(4)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/preschoolers/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__5"></div>
                            </div>
                            <div class="homepage-clubs_tx">Дошкольники</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(5)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/schoolers/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__6"></div>
                            </div>
                            <div class="homepage-clubs_tx">Школьники</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(6)?></div></a></li>
                </ul>
            </div>
            <!-- collection-->
            <div class="homepage-clubs_collection homepage-clubs_collection__3">
                <div class="homepage-clubs_title-hold">
                    <div class="homepage-clubs_title">Наш дом</div>
                </div>
                <ul class="homepage-clubs_ul">
                    <li class="homepage-clubs_li"><a href="/cook/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__7"></div>
                            </div>
                            <div class="homepage-clubs_tx">Готовим на кухне</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(7)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/homework/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__9"></div>
                            </div>
                            <div class="homepage-clubs_tx">Домашние хлопоты</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(9)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/pets/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__11"></div>
                            </div>
                            <div class="homepage-clubs_tx">Наши питомцы</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(11)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/garden/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__10"></div>
                            </div>
                            <div class="homepage-clubs_tx">Сад и огород </div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(10)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/repair-house/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__8"></div>
                            </div>
                            <div class="homepage-clubs_tx">Ремонт в доме</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(8)?></div></a></li>
                </ul>
            </div>
            <!-- collection-->
            <div class="homepage-clubs_collection homepage-clubs_collection__4">
                <div class="homepage-clubs_title-hold">
                    <div class="homepage-clubs_title">Красота и здоровье</div>
                </div>
                <ul class="homepage-clubs_ul">
                    <li class="homepage-clubs_li"><a href="/beauty-and-fashion/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__12"></div>
                            </div>
                            <div class="homepage-clubs_tx">Красота и мода</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(12)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/health/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__13"></div>
                            </div>
                            <div class="homepage-clubs_tx">Наше здоровье</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(13)?></div></a></li>
                </ul>
            </div>
            <!-- collection-->
            <div class="homepage-clubs_collection homepage-clubs_collection__5">
                <div class="homepage-clubs_title-hold">
                    <div class="homepage-clubs_title">Интересы и увлечения</div>
                </div>
                <ul class="homepage-clubs_ul">
                    <li class="homepage-clubs_li"><a href="/auto/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__18"></div>
                            </div>
                            <div class="homepage-clubs_tx">Наш автомобиль</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(18)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/needlework/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__16"></div>
                            </div>
                            <div class="homepage-clubs_tx">Рукоделие</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(16)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/homeflowers/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__17"></div>
                            </div>
                            <div class="homepage-clubs_tx">Цветы в доме</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(17)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/fishing/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__19"></div>
                            </div>
                            <div class="homepage-clubs_tx">Рыбалка</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(19)?></div></a></li>
                </ul>
            </div>
            <!-- collection-->
            <div class="homepage-clubs_collection homepage-clubs_collection__6">
                <div class="homepage-clubs_title-hold">
                    <div class="homepage-clubs_title">Семейный отдых</div>
                </div>
                <ul class="homepage-clubs_ul">
                    <li class="homepage-clubs_li"><a href="/weekends/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__21"></div>
                            </div>
                            <div class="homepage-clubs_tx">Выходные с семьей</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(21)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/travel/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__20"></div>
                            </div>
                            <div class="homepage-clubs_tx">Мы путешествуем</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(20)?></div></a></li>
                    <li class="homepage-clubs_li"><a href="/holidays/" class="homepage-clubs_a">
                            <div class="homepage-clubs_ico-hold">
                                <div class="ico-club ico-club__22"></div>
                            </div>
                            <div class="homepage-clubs_tx">Семейные праздники</div><div class="homepage-clubs_comments"><?=\site\frontend\modules\community\helpers\StatsHelper::getSubscribers(22)?></div></a></li>
                </ul>
            </div>
        </div>
        <div class="homepage-clubs_b">
            <div class="homepage-clubs_btn-hold"><a class="homepage_btn-sign btn btn-xxl registration-button" data-bind="follow: {}">Начни общаться!</a></div>
            <div class="homepage_desc-tx">узнавай новое, делись самым интересным </div>
        </div>
    </div>
</div>
<!-- /Клубы-->
