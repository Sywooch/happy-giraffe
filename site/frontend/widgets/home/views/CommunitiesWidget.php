<div class="box homepage-clubs">

    <div class="title"><span>Клубы</span> для общения</div>

    <ul>

    <?php $n = 0; ?>
    <?php foreach($categories as $title => $category): ?>
    <div class="category-title <?php echo $category['css'] ?>"><?php echo $title; ?></div>
        <?php if(isset($category['items'])): ?>
            <?php foreach($category['items'] as $subtitle => $subcount): ?>
            <div class="subcategory <?php echo $category['css'] ?>">
                <div class="subcategory-title"><?php echo $subtitle; ?></div>
                <ul>
                    <?php for($i = 0;$i < $subcount; $i++): ?>
                    <li class="club-img <?php echo $category['css'] ?>">
                        <a href="<?php echo $this->createUrl('community/list', array('community_id' => $communities[$n]->id)); ?>">
                            <img src="/images/club_img_<?php echo $communities[$n]->position; ?>.png">
                            <?php echo $communities[$n]->name; ?>
                        </a>
                    </li>
                    <?php $n++; ?>
                    <?php endfor; ?>
                </ul>
            </div>
                <?php endforeach; ?>
            <?php else: ?>
        <ul>
            <?php for($i = 0;$i < $category['count']; $i++): ?>
            <?php if(!isset($communities[$n])) continue; ?>
            <li class="club-img <?php echo $category['css'] ?>">
                <a href="<?php echo $this->createUrl('community/list', array('community_id' => $communities[$n]->id)); ?>">
                    <img src="/images/club_img_<?php echo $communities[$n]->position; ?>.png">
                    <?php echo $communities[$n]->name; ?>
                </a>
            </li>
            <?php $n++; ?>
            <?php endfor; ?>
        </ul>
            <?php endif; ?>
        <?php endforeach; ?>


        <li class="kids">
            <div class="category-title">Дети и беременность</div>
            <ul>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_1.png"></span>
                        <span class="club-title">Планирование</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_4.png"></span>
                        <span class="club-title">Дети до года</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_8.png"></span>
                        <span class="club-title">Дети старше года</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_12.png"></span>
                        <span class="club-title">Дошкольники</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_15.png"></span>
                        <span class="club-title">Школьники</span>
                    </a>
                </li>

            </ul>
        </li>
        <li class="manwoman">
            <div class="category-title">Мужчина <span>&amp;</span> женщина</div>
            <ul>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_19.png"></span>
                        <span class="club-title">Отношения</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_20.png"></span>
                        <span class="club-title">Свадьба</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="beauty">
            <div class="category-title">Красота и здоровье</div>
            <ul>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_21.png"></span>
                        <span class="club-title">Красота</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_22.png"></span>
                        <span class="club-title">Мода и шопинг</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_23.png"></span>
                        <span class="club-title">Здоровье родителей</span>
                    </a>
                </li>

            </ul>
        </li>
        <li class="home">
            <div class="category-title">Дом</div>
            <ul>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_24.png"></span>
                        <span class="club-title">Кулинарные рецепты</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_25.png"></span>
                        <span class="club-title">Детские рецепты</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_26.png"></span>
                        <span class="club-title">Интерьер и дизайн</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_27.png"></span>
                        <span class="club-title">Домашние хлопоты</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_28.png"></span>
                        <span class="club-title">Загородная жизнь</span>
                    </a>
                </li>

            </ul>
        </li>
        <li class="hobbies">
            <div class="category-title">Интересы и увлечения</div>
            <ul>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_29.png"></span>
                        <span class="club-title">Своими руками</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_30.png"></span>
                        <span class="club-title">Мастерим детям</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_31.png"></span>
                        <span class="club-title">За рулем</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_32.png"></span>
                        <span class="club-title">Цветоводство</span>
                    </a>
                </li>

            </ul>
        </li>
        <li class="rest">
            <div class="category-title">Отдых</div>
            <ul>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_29.png"></span>
                        <span class="club-title">Выходные с ребенком</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_30.png"></span>
                        <span class="club-title">Путешествия семьей</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="club-img"><img src="/images/club_img_31.png"></span>
                        <span class="club-title">Праздники</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</div>