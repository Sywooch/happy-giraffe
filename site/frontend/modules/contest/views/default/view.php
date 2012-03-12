<div id="contest">
    <div class="contest-about clearfix">
        <div class="sticker">
            <big>Для участия в конкурсе Вам необходимо</big>
            <ul>
                <li>Заполнить профиль;</li>
                <li>Добавить информацию о ребенке (возраст и имя);</li>
                <li>Написать хотя бы один пост в блоге/сообществе.</li>
            </ul>
            <a href="#takeapartPhotoContest" class="btn btn-green-arrow-big fancy"><span><span>Участвовать</span></span></a>
        </div>
        <div class="content-title">О конкурсе</div>
        <p>Каждая мама считает, что ее ребенок самый лучший, и мы не можем предлагать вам выбирать лучшего ребенка. Но вот выбирать лучшую фотографию вашего ребенка мы как раз можем!</p>
        <p>I этап. В течение месяца пользователи глосуют за понравившиеся фото. Чем больше ваших друзей проголосует за вашу фотографию, тем больше 	шансов у вас победить!</p>
        <p>II этап. Из 30 победителей I тура жюри выбирает победителя конкурса, который получает главный приз — набор подгузников.</p>
    </div>
    <?php if(count($contest->prizes) > 0): ?>
        <div class="content-title">Вас ждут замечательные призы!</div>
        <div class="prise-block clearfix">
            <?php foreach ($contest->prizes as $p): ?>
                <div class="item">
                    <?php echo CHtml::image(str_replace('club', 'shop', $p->product->product_image->getUrl('product_contest')), $p->product->product_title); ?>
                    <span><?php echo $p->prize_place; ?> место</span>
                    <p><?php echo $p->prize_text; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

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
                    <?php foreach ($contest->getRelated('works', false, array('limit' => 3, 'order' => 'work_id desc')) as $w): ?>
                        <li>
                            <table>
                                <tr>
                                    <td class="img"><div><?php echo CHtml::link(CHtml::image($w->work_image->getUrl('thumb'), $w->work_title), $this->createUrl('/contest/work/' . $w->work_id)); ?></div></td>
                                </tr>
                                <tr class="rank"><td><span><?php echo Rating::model()->countByEntity($w); ?></span> баллов</td></tr>
                                <tr class="title">
                                    <td align="center"><div><?php echo $w->work_title; ?></div></td>
                                </tr>
                            </table>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>