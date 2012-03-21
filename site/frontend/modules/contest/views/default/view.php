<div id="contest">
    <div class="contest-about clearfix">
        <?php if($this->contest->isStatement): ?>
            <div class="sticker">
                <big>Для того, чтобы принять участие в конкурсе, вы должны заполнить свой профиль и информацию о членах своей семьи!</big>
                <?php echo CHtml::link('<span><span>Участвовать</span></span>', array('/contest/statement', 'id' => $contest->primaryKey), array('class' => 'btn btn-green-arrow-big')) ?>
            </div>
        <?php endif; ?>
        <div class="content-title">О конкурсе</div>
        <p>
            Весёлый жираф предлагает познакомиться! Ваша семья самая весёлая, самая интересная  – в общем, самая-самая? Тогда приглашаем вас принять участие в конкурсе семейной фотографии. Присылайте фото себя и своих близких на катке, на море или даже на рыбалке. Не важно, где сделан снимок, главное, чтобы он вызывал улыбку!
             Обратите внимание: к участию допускается только одно фото от одного пользователя! Победителей выберут пользователи путём голосования – поэтому смело приглашайте голосовать своих друзей и знакомых. Удачи!
        </p>
    </div>

    <div class="content-title">Вас ждут замечательные призы!</div>
    <div class="prise-block clearfix">

        <div class="item">
            <img src="/images/example/prize.png">
            <span>1 место</span>
            <p>Описание приза</p>
        </div>

        <div class="item">
            <img src="/images/example/prize.png">
            <span>2 место</span>
            <p>Описание приза</p>
        </div>

        <div class="item">
            <img src="/images/example/prize.png">
            <span>3 место</span>
            <p>Держатель для стаканов Phil and Teds ( Фил энд Тедс)</p>
        </div>

        <div class="item">
            <img src="/images/example/prize.png">
            <span>3 место</span>
            <p>Держатель для стаканов Phil and Teds ( Фил энд Тедс)</p>
        </div>

        <div class="item">
            <img src="/images/example/prize.png">
            <span>3 место</span>
            <p>Держатель для стаканов Phil and Teds ( Фил энд Тедс)</p>
        </div>
    </div>
    <?php /*if(count($contest->prizes) > 0): */?><!--
        <div class="content-title">Вас ждут замечательные призы!</div>
        <div class="prise-block clearfix">
            <?php /*foreach ($contest->prizes as $p): */?>
                <div class="item">
                    <?php /*echo CHtml::image(str_replace('club', 'shop', $p->product->product_image->getUrl('product_contest')), $p->product->product_title); */?>
                    <span><?php /*echo $p->prize_place; */?> место</span>
                    <p><?php /*echo $p->prize_text; */?></p>
                </div>
            <?php /*endforeach; */?>
        </div>
    --><?php /*endif;*/ ?>

    <?php if(count($contest->works) > 0): ?>
        <div class="content-title">
            Последние добавленные фото
            <?php echo CHtml::link('<span><span>Показать все</span></span>', array('/contest/list/' . $contest->contest_id), array(
                'class' => 'btn btn-blue-small'
            )); ?>
        </div>
        <div id="gallery">
            <div class="gallery-photos clearfix">
                <ul>
                    <?php foreach ($contest->getRelated('works', false, array('limit' => 3, 'order' => 'id desc')) as $w): ?>
                        <li>
                            <table>
                                <tr>
                                    <td class="img"><div><?php echo CHtml::link(CHtml::image($w->photo->photo->getPreviewUrl(150, 150), $w->title), $this->createUrl('/contest/work/' . $w->id)); ?></div></td>
                                </tr>
                                <tr class="rank"><td><span><?php echo $w->rate; ?></span> баллов</td></tr>
                                <tr class="title">
                                    <td align="center"><div><?php echo $w->title; ?></div></td>
                                </tr>
                            </table>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>