<div class="menu">
    <ul class="menu_ul">
        <li class="menu_li">
            <a class="menu_i" href="<?=$this->createUrl('/valentinesDay/default/index') ?>">
                <span class="menu_hold"><i class="menu_ico menu_ico__valentine-day"></i></span>
                <span class="menu_frame"><span class="menu_t menu_t__color-red">День святого Валентина</span></span>
            </a>
            <img class="menu_tale" alt="" src="/images/menu_tale.png">
        </li>
        <li class="menu_li">
            <a class="menu_i" href="<?=$this->createUrl('/cook/recipe/tag', array('tag'=>CookRecipeTag::TAG_VALENTINE)) ?>">
                <span class="menu_hold"><i class="menu_ico menu_ico__cook"></i></span>
                <span class="menu_frame"><span class="menu_t">Что приготовить</span></span>
            </a>
            <img class="menu_tale" alt="" src="/images/menu_tale.png">
        </li>
        <li class="menu_li<? if (Yii::app()->controller->action->id == 'sms') echo ' active' ?>">
            <a class="menu_i" href="<?=$this->createUrl('/valentinesDay/default/sms') ?>">
                    <span class="menu_hold"><i class="menu_ico menu_ico__tel"></i></span>
                    <span class="menu_frame"><span class="menu_t">СМС к дню святого Валентина</span></span>
            </a>
            <img class="menu_tale" alt="" src="/images/menu_tale.png">
        </li>
        <li class="menu_li">
            <a class="menu_i" href="<?=$this->createUrl('/valentinesDay/default/index') ?>">
                <span class="menu_hold"><i class="menu_ico menu_ico__valentines"></i></span>
                <span class="menu_frame"><span class="menu_t">Валентинки</span></span>
            </a>
            <img class="menu_tale" alt="" src="/images/menu_tale.png">
        </li>
        <li class="menu_li<? if (Yii::app()->controller->action->id == 'howToSpend') echo ' active' ?>">
            <a class="menu_i" href="<?=$this->createUrl('/valentinesDay/default/howToSpend') ?>">
                <span class="menu_hold"><i class="menu_ico menu_ico__photo"></i></span>
                <span class="menu_frame"><span class="menu_t">Фото. Как провести день святого Валентина</span></span>
            </a>
            <img class="menu_tale" alt="" src="/images/menu_tale.png">
        </li>
        <li class="menu_li">
            <a class="menu_i" href="<?=$this->createUrl('/valentinesDay/default/index') ?>">
                <span class="menu_hold"><i class="menu_ico menu_ico__video"></i></span>
                <span class="menu_frame"><span class="menu_t">Видео. 10 лучших признаний в любви</span></span>
            </a>
            <img class="menu_tale" alt="" src="/images/menu_tale.png">
        </li>
    </ul>
</div>