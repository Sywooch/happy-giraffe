<div class="header-drop">
    <div class="header-menu clearfix">
        <ul class="header-menu_ul">
            <li class="header-menu_li">
                <a href="<?=$user->getUrl()?>" class="header-menu_a">
                    <span class="header-menu_ico header-menu_ico__profile"></span>
                    <span class="header-menu_tx">Моя страница</span>
                </a>
            </li>
            <li class="header-menu_li">
                <a href="<?=Yii::app()->user->model->getFamilyUrl()?>" class="header-menu_a">
                    <span class="header-menu_ico header-menu_ico__family"></span>
                    <span class="header-menu_tx">Моя семья</span>
                </a>
            </li>

            <li class="header-menu_li">
                <a href="<?=Yii::app()->user->model->getBlogUrl()?>" class="header-menu_a">
                    <span class="header-menu_ico header-menu_ico__blog"></span>
                    <span class="header-menu_tx">Мой блог</span>
                </a>
            </li>
            <li class="header-menu_li">
                <a href="<?=Yii::app()->user->model->getPhotosUrl()?>" class="header-menu_a">
                    <span class="header-menu_ico header-menu_ico__photo"></span>
                    <span class="header-menu_tx">Мои фото</span>
                </a>
            </li>
            <li class="header-menu_li">
                <a href="<?=$this->createUrl('/favourites/default/index')?>" class="header-menu_a">
                    <span class="header-menu_ico header-menu_ico__favorite"></span>
                    <span class="header-menu_tx">Избранное</span>
                </a>
            </li>
            <li class="header-menu_li">
                <a href="/user/settings/" class="header-menu_a">
                    <span class="header-menu_ico header-menu_ico__settings"></span>
                    <span class="header-menu_tx">Мои настройки</span>
                </a>
            </li>
            <li class="header-menu_li">
                <a href="<?=Yii::app()->createUrl('/site/logout')?>" class="header-menu_a">
                    <span class="header-menu_ico header-menu_ico__logout"></span>
                    <span class="header-menu_tx"></span>
                </a>
            </li>



        </ul>
    </div>
    <?php if ($user->clubSubscriptionsCount > 0): ?>
        <div class="header-drop_b">
            <div class="float-r margin-t3">
                <a href="<?=$this->createUrl('/myGiraffe/default/recommends')?>">Жираф рекомендует</a>
            </div>
            <div class="heading-small">Мои клубы <span class="color-gray">(<?=$user->clubSubscriptionsCount?>)</span> </div>


            <div class="club-list club-list__small clearfix">
                <ul class="club-list_ul clearfix">
                    <?php foreach ($user->clubSubscriptions as $cs): ?>
                    <li class="club-list_li">
                        <a href="<?=$cs->club->getUrl()?>" class="club-list_i"><span class="club-list_img-hold"><img src="/images/club/<?=$cs->club_id?>-w50.png" alt="" class="club-list_img"></span></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    <?php endif; ?>
</div>