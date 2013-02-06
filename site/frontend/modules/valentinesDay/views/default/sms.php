<div class="content-cols margin-t20 clearfix">
    <div class="col-1">

        <div class="menu">
            <ul class="menu_ul">
                <li class="menu_li">
                    <a class="menu_i" href="">
									<span class="menu_hold">
										<i class="menu_ico menu_ico__valentine-day"></i>
									</span>
									<span class="menu_frame">
										<span class="menu_t menu_t__color-red">День святого Валентина</span>
									</span>
                    </a>
                    <img class="menu_tale" alt="" src="/images/menu_tale.png">
                </li>
                <li class="menu_li">
                    <a class="menu_i" href="">
									<span class="menu_hold">
										<i class="menu_ico menu_ico__cook"></i>
									</span>
									<span class="menu_frame">
										<span class="menu_t">Что приготовить</span>
									</span>
                    </a>
                    <img class="menu_tale" alt="" src="/images/menu_tale.png">
                </li>
                <li class="menu_li active">
                    <a class="menu_i" href="">
									<span class="menu_hold">
										<i class="menu_ico menu_ico__tel"></i>
									</span>
									<span class="menu_frame">
										<span class="menu_t">СМС к дню святого Валентина</span>
									</span>
                    </a>
                    <img class="menu_tale" alt="" src="/images/menu_tale.png">
                </li>
                <li class="menu_li">
                    <a class="menu_i" href="">
									<span class="menu_hold">
										<i class="menu_ico menu_ico__valentines"></i>
									</span>
									<span class="menu_frame">
										<span class="menu_t">Валентинки</span>
									</span>
                    </a>
                    <img class="menu_tale" alt="" src="/images/menu_tale.png">
                </li>
                <li class="menu_li">
                    <a class="menu_i" href="">
									<span class="menu_hold">
										<i class="menu_ico menu_ico__photo"></i>
									</span>
									<span class="menu_frame">
										<span class="menu_t">Фото. Как провести день святого Валентина</span>
									</span>
                    </a>
                    <img class="menu_tale" alt="" src="/images/menu_tale.png">
                </li>
                <li class="menu_li">
                    <a class="menu_i" href="">
									<span class="menu_hold">
										<i class="menu_ico menu_ico__video"></i>
									</span>
									<span class="menu_frame">
										<span class="menu_t">Видео. 10 лучших признаний в любви</span>
									</span>
                    </a>
                    <img class="menu_tale" alt="" src="/images/menu_tale.png">
                </li>
            </ul>
        </div>

    </div>
    <div class="col-12">
        <div class="valentine-sms">
            <div class="valentine-sms_hold">
                <div class="valentine-sms_t"></div>
                <p class="valentine-sms_p">В день святого Валентина принято обмениваться смс о любви и маленькими
                    подарками. Если вы еще не знаете, как поздравить с днем святого Валентина свою вторую половинку -
                    пришлите ей смс с признанием в любви.</p>
            </div>
            <?php foreach ($models as $model): ?>
                <div class="valentine-sms-b valentine-sms-b__withe">
                    <span class="valentine-sms-b_t">«<?=$model->title ?>»</span>
    							<span class="valentine-sms-b_p">
    								<?=$model->text ?>
    							</span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="pagination pagination-center clearfix">
            <div class="pager">
                <ul>
                    <li class="previous"><a href="">...</a></li>
                    <li><a href="">1</a></li>
                    <li><a href="">2</a></li>
                    <li class="selected"><a href="">321</a><img src="/images/pagination_tale.png"></li>
                    <li><a href="">4</a></li>
                    <li class="selected"><a href="">5</a><img src="/images/pagination_tale.png"></li>
                    <li><a href="">6</a></li>
                    <li><a href="">7</a></li>
                    <li class="next"><a href="">...</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>