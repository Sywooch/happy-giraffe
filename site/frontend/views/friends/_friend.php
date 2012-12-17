<li class="masonry-news-list_item">
    <?php if ($data->online): ?>
        <div class="online-status">На сайте</div>
    <?php endif; ?>
    <div class="user-info-big clearfix">
        <div class="user-info clearfix">
            <?php
                $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $data,
                    'small' => true,
                ));
            ?>
            <div class="details">
                <a class="username" href="<?=$data->url?>"><?=$data->fullName?></a>
                <?php if ($data->birthday !== null): ?>
                    <div class="date"><?=$data->normalizedAge?> (<?=$data->birthdayString?>)</div>
                <?php endif; ?>
                <?php if ($data->address->country_id): ?>
                    <div class="location"><?=$data->address->flag?><?=$data->address->locationWithoutCountry?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="user-fast-buttons">
        <?php Yii::app()->controller->renderPartial('//user/_friend_button', array(
            'user' => $data,
        )); ?>
        <?php Yii::app()->controller->renderPartial('//user/_dialog_button', array(
            'user' => $data,
        )); ?>
        <a href="<?=$data->url?>">Анкета</a>
        <a href="<?=$data->blogUrl?>">Блог</a><sup class="count"><?=$data->blogPostsCount?></sup>
        <a href="<?=$data->photosUrl?>">Фото</a><sup class="count"><?=$data->photosCount?></sup>
    </div>
    <?php if ($data->hasPartner() || ! empty($data->babies)): ?>
        <div class="find-friend-famyli">
            <div class="textalign-c clearfix">
                <img alt="Моя семья" src="/images/user-family.png">
            </div>
            <ul class="find-friend-famyli-list">
                <?php if ($data->hasPartner() && $data->partner !== null): ?>
                    <?php $this->renderPartial('_partner', array('partner' => $data->partner)); ?>
                <?php endif; ?>
                <?php foreach ($data->babies as $b): ?>
                    <?php $this->renderPartial('_baby', array('baby' => $b)); ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

</li>