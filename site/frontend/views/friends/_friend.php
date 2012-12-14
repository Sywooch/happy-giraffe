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
        <a class="add-friend" href=""><span class="tip">Пригласить в друзья</span></a>
        <a class="new-message" href=""><span class="tip">Написать сообщение</span></a>
        <a href="">Анкета</a>
        <a href="">Блог</a><sup class="count">9999</sup>
        <a href="">Фото</a><sup class="count">9999</sup>
    </div>
    <div class="find-friend-famyli">
        <div class="textalign-c clearfix">
            <img alt="" src="/images/user-family.png">
        </div>
        <ul class="find-friend-famyli-list">
            <li>
                <div class="img"><img src="/images/example/w52-h34-1.jpg" alt="" /></div>
                <span class="yellow">Жена</span> <br />
                <span>Светлана</span>
            </li>
            <li>
                <div class="img"><img src="/images/example/w52-h34-1.jpg" alt="" /></div>
                <span class="yellow">Дочь</span> <br />
                <span>Евгения</span> <br />
                <span class="yellow">3 мес.</span>
            </li>
            <li>
                <div class="img"><img src="/images/example/w41-h49-1.jpg" alt="" /></div>
                <span class="yellow">Дочь</span> <br />
                <span>Евгения</span> <br />
                <span class="yellow">3 мес.</span>
            </li>
        </ul>
    </div>

</li>