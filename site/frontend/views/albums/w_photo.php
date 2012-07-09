<?php
    /* @var AlbumsController $this
     * @var HActiveRecord $model
     * @var AlbumPhoto $photo
     */
    $selected_index = null;
    $collection = $model->photoCollection;
    $count = count($model->photoCollection);
?>

<div id="photo-window-in">

    <div class="top-line clearfix">

        <a href="javascript:void(0);" class="close" onclick="closePhoto();"></a>

        <div class="user">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $photo->author,
                'size' => 'small',
                'sendButton' => false,
                'location' => false
            )); ?>
        </div>

        <div class="photo-info">
            Альбом  «Оформление вторые блюда» - <span class="count">3 фото из 158</span>
            <div class="title">Жареный картофель с беконом</div>
        </div>

    </div>

    <script type="text/javascript">
        <?php ob_start(); ?>
        <?php foreach ($collection as $i => $p): ?>
            pGallery.photos[<?php echo $p->primaryKey ?>] = {
                prev : <?=($i != 0) ? $collection[--$i]->primaryKey : 'null'?>,
                next : <?=($i < $count - 1) ? $collection[++$i]->primaryKey : 'null'?>,
                src : '<?php echo $p->getPreviewUrl(960, 627, Image::HEIGHT, true); ?>',
                title : '<?php echo isset($p->title) && $p->title != '' ? $p->title : null ?>',
                description : <?php echo isset($p->options['description']) ? "'" . $p->options['description'] . "'" : 'null'; ?>,
                avatar : '<?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $p->author,
                    'size' => 'small',
                    'sendButton' => false,
                    'location' => false
                )); ?>'
            };

            <?php if ($i == 0): ?>
                $.pGallery.first = <?=$p->primaryKey?>;
            <?php endif; ?>

            <?php if ($i < $count - 1): ?>
            $.pGallery.last = <?=$p->primaryKey?>;
                <?php endif; ?>
        <?php endforeach; ?>
        <?
            $params = ob_get_contents();
            ob_end_clean();
            echo preg_replace('/\s+/i', ' ', $params);
        ?>
    </script>

    <div id="photo">

        <div class="img">
            <table><tr><td><?=CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT, true), '')?></td></tr></table>
        </div>

        <a href="javascript:void(0)" class="prev"><i class="icon"></i>предыдушая</a>
        <a href="javascript:void(0)" class="next"><i class="icon"></i>следующая</a>

    </div>

    <div class="photo-comment">
        <p>Квашеная капуста с клюквой, грибами, соусом, зеленью и еще очень длинный комментарий про это оформление блюда, да нужно двести знаков для этого комментария, уже вроде набралось или нет кто будет считать</p>
    </div>


    <div id="photo-content">

        <div class="like-block fast-like-block">

            <div class="box-1">
                <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                Поделиться
                <div class="yashare-auto-init" data-yasharel10n="ru" data-yasharetype="none" data-yasharequickservices="vkontakte,facebook,twitter,odnoklassniki,moimir,gplus"><span class="b-share"><a rel="nofollow" target="_blank" title="ВКонтакте" class="b-share__handle b-share__link" href="http://share.yandex.ru/go.xml?service=vkontakte&amp;url=http%3A%2F%2Fhg.local%2Fhtml%2Fsocial%2Farticle_2.0.html&amp;title=Untitled%20Document" data-service="vkontakte"><span class="b-share-icon b-share-icon_vkontakte"></span></a><a rel="nofollow" target="_blank" title="Facebook" class="b-share__handle b-share__link" href="http://share.yandex.ru/go.xml?service=facebook&amp;url=http%3A%2F%2Fhg.local%2Fhtml%2Fsocial%2Farticle_2.0.html&amp;title=Untitled%20Document" data-service="facebook"><span class="b-share-icon b-share-icon_facebook"></span></a><a rel="nofollow" target="_blank" title="Twitter" class="b-share__handle b-share__link" href="http://share.yandex.ru/go.xml?service=twitter&amp;url=http%3A%2F%2Fhg.local%2Fhtml%2Fsocial%2Farticle_2.0.html&amp;title=Untitled%20Document" data-service="twitter"><span class="b-share-icon b-share-icon_twitter"></span></a><a rel="nofollow" target="_blank" title="Одноклассники" class="b-share__handle b-share__link" href="http://share.yandex.ru/go.xml?service=odnoklassniki&amp;url=http%3A%2F%2Fhg.local%2Fhtml%2Fsocial%2Farticle_2.0.html&amp;title=Untitled%20Document" data-service="odnoklassniki"><span class="b-share-icon b-share-icon_odnoklassniki"></span></a><a rel="nofollow" target="_blank" title="Мой Мир" class="b-share__handle b-share__link" href="http://share.yandex.ru/go.xml?service=moimir&amp;url=http%3A%2F%2Fhg.local%2Fhtml%2Fsocial%2Farticle_2.0.html&amp;title=Untitled%20Document" data-service="moimir"><span class="b-share-icon b-share-icon_moimir"></span></a><a rel="nofollow" target="_blank" title="Google Plus" class="b-share__handle b-share__link" href="http://share.yandex.ru/go.xml?service=gplus&amp;url=http%3A%2F%2Fhg.local%2Fhtml%2Fsocial%2Farticle_2.0.html&amp;title=Untitled%20Document" data-service="gplus"><span class="b-share-icon b-share-icon_gplus"></span></a></span></div>
            </div>

            <div class="box-2">

                <div class="like-btn">
                    <a href="" class="btn-icon heart active"></a>
                    <div class="count">286</div>
                </div>

            </div>

            <div class="box-3">
                <div class="rating"><span>286</span></div>
                <div class="icon-info">
                    <div class="tip">
                        <big>Рейтинг статьи</big>
                        <p>Как правило, кроватку новорождому приобретают незадолго до его появления на свет. При этом многие молодые родители обращают внимание главным образом на ее внешний вид.</p>

                        <p>Как правило, кроватку новорождому приобретают незадолго до его появления на свет. При этом многие молодые родители обращают внимание главным образом на ее внешний вид.</p>
                    </div>
                </div>
                <span class="label">баллов</span>
            </div>

        </div>

        <div class="default-comments">

            <div class="comments-meta clearfix">
                <a href="" class="btn btn-orange a-right"><span><span>Добавить комментарий</span></span></a>
                <div class="title">Комментарии</div>
                <div class="count">55</div>
            </div>

            <ul>
                <li class="author-comment">
                    <div class="comment-in clearfix">
                        <div class="header clearfix">
                            <div class="user-info clearfix">
                                <div class="ava female"></div>
                                <div class="details">
                                    <span class="icon-status status-online"></span>
                                    <a href="" class="username">Дарья</a>
                                    <div class="user-fast-buttons clearfix">
                                        <a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
                                        <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <div class="meta">
                                <span class="num">1</span>
                                <span class="date">Сегодня, 20:45</span>
                            </div>
                            <div class="content-in">
                                <div class="wysiwyg-content">
                                    <h2>Как выбрать детскую коляску</h2>

                                    <p>Как правило, кроватку новорожденному приобретают незадолго до его появления на свет. При этом многие молодые <b>родители</b> обращают внимание главным <u>образом</u> на ее <strike>внешний</strike> вид. Но, прельстившись яркими красками, многие платят баснословные суммы, даже не поинтересовавшись, из чего сделано это покорившее вас чудо.</p>

                                    <p><img src="/images/example/12.jpg" width="300" class="content-img"><i>Атопический дерматит у детей до года локализуется в основном на щечках и ягодицах, реже на теле и конечностях, на коже головы возможно появление корочек. Когда малышу исполнится год, то места высыпаний меняются – теперь поражаются локтевые сгибы (внутри и снаружи), подколенные впадины, шея. После трех лет высыпания начинают поражать также и кисти рук.</i></p>

                                    <h3>Как выбрать детскую коляску</h3>

                                    <ul>
                                        <li>Приходишь в детский магазин - глаза разбегаются: столько всего, что порой забываешь, зачем пришел. <a href="">Немало и разновидностей детских кроваток</a>: тут и люльки для младенцев</li>
                                        <li>И кроватки-"домики" - с навесом в виде крыши, и кровати в стиле "евростандарт" - выкрашенные в белый цвет, и даже претендующие на готический стиль, </li>
                                        <li>Есть и продукция попроще. Не покупайте ничего под влиянием первых эмоций. </li>
                                    </ul>

                                    <h3>Как выбрать детскую коляску</h3>

                                    <ol>
                                        <li>Приходишь в детский магазин - глаза разбегаются: столько всего, что порой забываешь, зачем пришел. <a href="">Немало и разновидностей детских кроваток</a>: тут и люльки для младенцев</li>
                                        <li>И кроватки-"домики" - с навесом в виде крыши, и кровати в стиле "евростандарт" - выкрашенные в белый цвет, и даже претендующие на готический стиль, </li>
                                        <li>Есть и продукция попроще. Не покупайте ничего под влиянием первых эмоций. </li>
                                    </ol>
                                </div>
                            </div>
                            <div class="actions">
                                <a href="" class="claim">Нарушение!</a>
                                <div class="admin-actions">
                                    <a href="" class="edit"><i class="icon"></i></a>
                                    <a href="#deleteComment" class="remove fancy"><i class="icon"></i></a>
                                </div>
                                <a href="">Ответить</a>
                                &nbsp;
                                <a href="" class="quote-link">С цитатой</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="comment-in clearfix">
                        <div class="header clearfix">
                            <div class="user-info clearfix">
                                <div class="ava female"></div>
                                <div class="details">
                                    <span class="icon-status status-online"></span>
                                    <a href="" class="username">Дарья</a>
                                    <div class="user-fast-buttons clearfix">
                                        <a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
                                        <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <div class="meta">
                                <span class="num">2</span>
                                <span class="date">Сегодня, 20:45</span>
                            </div>
                            <div class="content-in">
                                <p>Коляска просто супер!!! Очень удобная и функциональная. Ни разу не пожалели, что купили именно эту коляску. Это маленький вездеход :)</p>
                            </div>
                            <div class="actions">
                                <a href="" class="claim">Нарушение!</a>
                                <div class="admin-actions">
                                    <a href="" class="edit"><i class="icon"></i></a>
                                    <a href="#deleteComment" class="remove fancy"><i class="icon"></i></a>
                                </div>
                                <a href="">Ответить</a>
                                &nbsp;
                                <a href="" class="quote-link">С цитатой</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="comment-in clearfix">
                        <div class="header clearfix">
                            <div class="user-info clearfix">
                                <div class="ava female"></div>
                                <div class="details">
                                    <span class="icon-status status-online"></span>
                                    <a href="" class="username">Дарья</a>
                                    <div class="user-fast-buttons clearfix">
                                        <span class="friend">друг</span>
                                        <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <div class="meta">
                                <span class="num">3</span>
                                <span class="date">Сегодня, 20:45</span>
                                <div class="answer">
                                    Ответ для
                                    <div class="user-info clearfix">
                                        <a onclick="return false;" class="ava female small" href="#">
                                            <img src="http://www.happy-giraffe.ru/upload/avatars/small/120316-10264-ya.jpg" alt="">
                                        </a>
                                    </div>
                                    на <span class="num"><a href="#">2</a></span>
                                </div>
                            </div>
                            <div class="content-in">
                                <div class="quote">
                                    <p>Коляска просто супер!!! Очень удобная и функциональная. Ни разу не пожалели, что купили именно эту коляску. Это маленький вездеход :)</p>
                                </div>
                                <p>Коляска просто супер!!! Очень удобная и функциональная. Ни разу не пожалели, что купили именно эту коляску. Это маленький вездеход :)</p>
                            </div>
                            <div class="actions">
                                <a href="" class="claim">Нарушение!</a>
                                <div class="admin-actions">
                                    <a href="" class="edit"><i class="icon"></i></a>
                                    <a href="#deleteComment" class="remove fancy"><i class="icon"></i></a>
                                </div>
                                <a href="">Ответить</a>
                                &nbsp;
                                <a href="" class="quote-link">С цитатой</a>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>

        </div>

    </div>

</div>