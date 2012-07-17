<div class="contest-about clearfix">

    <div class="sticker">
        <big>Для того, чтобы принять участие в конкурсе, вы должны</big>
        <ul>
            <li>Заполнить свой профиль;</li>

            <li>Добавить информацию о членах своей семьи.</li>
        </ul>
        <?php if($this->contest->isStatement): ?>
            <center><a href="<?=(Yii::app()->user->isGuest) ? '#login' : $this->createUrl('/contest/default/statement', array('id' => $this->contest->id))?>" class="btn btn-green-medium<?=(Yii::app()->user->isGuest) ? ' fancy' : ''?>" data-theme="white-square"><span><span>Участвовать<i class="arr-r"></i></span></span></a></center>
        <?php endif; ?>
    </div>

    <div class="content-title">О конкурсе</div>

    <p><b>Весёлый жираф предлагает познакомиться!</b></p>
    <p>Ваша семья самая весёлая, самая интересная  – в общем, самая-самая? Тогда приглашаем вас принять участие в конкурсе семейной фотографии. Присылайте свое фото и фото своих близких, сделанные на катке , море или даже рыбалке. Не важно, где сделан снимок, главное, чтобы он вызывал улыбку!</p>
    <p><b>Обратите внимание:</b> к участию допускается только одно фото от одного пользователя! Победителей выберут пользователи путём голосования – поэтому смело приглашайте голосовать своих друзей и знакомых. Удачи!</p>

</div>

<div class="content-title">Вас ждут замечательные призы!</div>

<div class="contest-prizes-list clearfix">

    <ul>
        <li>
            <div class="img">
                <a href=""><img src="/images/prize_1.jpg" /></a>
            </div>
            <div class="place place-1"></div>
            <div class="title">
                <a href="">Мультиварка<br/><b>Land Life YBW60-100A1 </b></a>
            </div>
        </li>
        <li>
            <div class="img">
                <a href=""><img src="/images/prize_2.jpg" /></a>
            </div>
            <div class="place place-2"></div>
            <div class="title">
                <a href="">Мультиварка<br/><b>BRAND 37501</b></a>
            </div>
        </li>
        <li>
            <div class="img">
                <a href=""><img src="/images/prize_3.jpg" /></a>
            </div>
            <div class="place place-3"></div>
            <div class="title">
                <a href="">Мультиварка<br/><b>Land Life YBD60-100A </b></a>
            </div>
        </li>
        <li>
            <div class="img">
                <a href=""><img src="/images/prize_4.jpg" /></a>
            </div>
            <div class="place place-4"></div>
            <div class="title">
                <a href="">Мультиварка<br/><b>Polaris PMC 0506AD</b></a>
            </div>
        </li>
        <li>
            <div class="img">
                <a href=""><img src="/images/prize_5.jpg" /></a>
            </div>
            <div class="place place-5"></div>
            <div class="title">
                <a href="">Мультиварка<br/><b>SUPRA MCS-4501</b></a>
            </div>
        </li>

    </ul>

</div>
<?php /*if(count($contest->prizes) > 0): */?><!--
    <div class="content-title">Вас ждут замечательные призы!</div>
    <div class="prise-block clearfix">
        <?php /*foreach ($contest->prizes as $p): */?>
            <div class="item">
                <?php /*echo CHtml::image(str_replace('club', 'shop', $p->product->product_image->getUrl('product_contest')), $p->product->product_title); */?>
                <span><?php /*echo $p->prize_place; */?> место</span>
                <p><?php /*echo $p->text; */?></p>
            </div>
        <?php /*endforeach; */?>
    </div>
--><?php /*endif;*/ ?>

<?php if(count($contest->works) > 0): ?>
    <div class="content-title">
        Последние добавленные работы
        <?php echo CHtml::link('<span><span>Показать все</span></span>', array('/contest/default/list', 'id' => $this->contest->id), array(
            'class' => 'btn btn-blue-small'
        )); ?>
    </div>
    <div id="gallery">
        <div class="gallery-photos clearfix">
            <ul>
                <?php foreach ($contest->getRelated('works', false, array('limit' => 10, 'order' => 'id desc')) as $w): ?>
                    <li>
                        <table>
                            <tr>
                                <td class="img"><div><?php echo CHtml::link(CHtml::image($w->photo->photo->getPreviewUrl(150, 150), $w->title), $this->createUrl('/contest/default/work', array('id' => $w->id))); ?></div></td>
                            </tr>
                            <tr class="title">
                                <td align="center"><div><?php echo $w->paredDownTitle; ?></div></td>
                            </tr>
                            <tr class="rank"><td><span><?php echo $w->rate; ?></span> баллов</td></tr>
                        </table>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>