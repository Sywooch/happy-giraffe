<?php $this->beginContent('//layouts/main'); ?>

<?php
    $cs = Yii::app()->clientScript;
    $inCommunity = (!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('createClubPost', array('user'=>Yii::app()->user->model,'community_id'=>$this->community->id)))?1:0;
    $js = "
        var inClub = {$inCommunity};
        $('body').delegate('a.joinButton', 'click', function(e) {
            e.preventDefault();
            $.ajax({
                dataType: 'JSON',
                url: $(this).attr('href'),
                success: function(response) {
                    if (response.status) {
                        $('a.club-join-btn').replaceWith(response.button);
                        inClub = response.inClub;
                        $.fancybox.close();
                    }
                },
                context: $(this)
            });
        });

        $('body').delegate('div.side-left div.club-fast-add a', 'click', function(e) {
            if (inClub)
                return true;
            else {
                $('a.club-join-btn').trigger('click');
                return false;
            }
        });

        $('body').delegate('div.default-comments .comments-meta a.btn', 'click', function(e) {
            if (inClub)
                return true;
            else {
                $('a.club-join-btn').trigger('click');
                return false;
            }
        });
    ";

    $cs
        ->registerCssFile('/stylesheets/user.css')
        ->registerScript('joinClub', $js);
?>

<?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => $this->breadcrumbs,
        'separator' => ' &gt; ',
        'htmlOptions' => array(
            'id' => 'crumbs',
            'class' => null,
        ),
    ));
?>

<div class="section-banner">
    <img src="/images/community/<?php echo $this->community->id; ?>.jpg"/>
</div>

<div class="clearfix">
    <div class="main">
        <div class="main-in">

            <div class="club-fast-nav default-nav">

                <?php if (! Yii::app()->user->isGuest): ?>
                    <?php $this->renderPartial('_joinButton', array(
                        'community_id' => $this->community->id,
                    )); ?>
                <?php endif; ?>

                <?php
                    if ($this->action->id == 'list') {
                        $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array(
                                    'label' => 'Все',
                                    'url' => $this->getUrl(array('content_type_slug' => null)),
                                    'active' => $this->content_type_slug === null,
                                    'linkOptions' => array(
                                        'rel' => 'nofollow',
                                    ),
                                ),
                                array(
                                    'label' => 'Статьи',
                                    'url' => $this->getUrl(array('content_type_slug' => 'post')),
                                    'active' => $this->content_type_slug == 'post',
                                    'linkOptions' => array(
                                        'rel' => 'nofollow',
                                    ),
                                ),
                                array(
                                    'label' => 'Путешествия',
                                    'url' => $this->getUrl(array('content_type_slug' => 'travel')),
                                    'active' => $this->content_type_slug == 'travel',
                                    'visible' => $this->community->id == 21,
                                    'linkOptions' => array(
                                        'rel' => 'nofollow',
                                    ),
                                ),
                                array(
                                    'label' => 'Видео',
                                    'url' => $this->getUrl(array('content_type_slug' => 'video')),
                                    'active' => $this->content_type_slug == 'video',
                                    'linkOptions' => array(
                                        'rel' => 'nofollow',
                                    ),
                                ),
                            ),
                        ));
                    }
                ?>

            </div>

            <?php echo $content; ?>

        </div>
    </div>

    <div class="side-left">

        <div class="club-fast-add">
            <?php if (Yii::app()->user->isGuest):?>
                <?=CHtml::link('<span><span>Добавить</span></span>', '#login', array('class' => 'btn btn-green fancy'))?>
            <?php else: ?>
                <?=HHtml::link('<span><span>Добавить</span></span>', $this->getUrl(array('content_type_slug' => null), 'community/add'), array('class' => 'btn btn-green'), true)?>
            <?php endif ?>
        </div>

        <div class="club-topics-all-link">
            <a href="<?=$this->getUrl(array('rubric_id' => null))?>">Все записи</a> <span class="count"><?=$this->community->getCount()?></span>
        </div>

        <div class="club-topics-list">
            <?php
                $this->renderPartial('parts/rubrics',array(
                    'rubrics' => $this->community->rubrics,
                    'type' => 'community',
                ));
            ?>
        </div>

        <div class="recent-topics">

            <div class="title">Последние темы</div>

            <ul>
                <?php foreach ($this->community->last as $c): ?>
                    <li><?=CHtml::link(CHtml::encode($c->title), $c->url)?></li>
                <?php endforeach; ?>
            </ul>

        </div>

        <?php if ($this->action->id == 'view'): ?>
            <div id="yandex_ad"></div>
            <script type="text/javascript">
                (function(w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function() {
                        Ya.Direct.insertInto(87026, "yandex_ad", {
                            site_charset: "utf-8",
                            ad_format: "direct",
                            font_size: 1,
                            type: "vertical",
                            limit: 1,
                            title_font_size: 2,
                            site_bg_color: "FFFFFF",
                            title_color: "006699",
                            url_color: "006699",
                            all_color: "000000",
                            text_color: "000000",
                            hover_color: "6699CC"
                        });
                    });
                    t = d.documentElement.firstChild;
                    s = d.createElement("script");
                    s.type = "text/javascript";
                    s.src = "http://an.yandex.ru/system/context.js";
                    s.setAttribute("async", "true");
                    t.insertBefore(s, t.firstChild);
                })(window, document, "yandex_context_callbacks");
            </script>

        <div class="yandexform" onclick="return {'bg': '#ffcc00', 'language': 'ru', 'encoding': 'utf-8', 'suggest': false, 'tld': 'ru', 'site_suggest': false, 'webopt': false, 'fontsize': 12, 'arrow': false, 'fg': '#000000', 'logo': 'rb', 'websearch': false, 'type': 2}"><form action="http://yandex.ru/sitesearch" method="get" target="_blank"><input type="hidden" name="searchid" value="1883818"/><input name="text"/><input type="submit" value="Найти"/></form></div><script type="text/javascript" src="http://site.yandex.net/load/form/1/form.js" charset="utf-8"></script>
        <?php endif; ?>
    </div>
</div>

<div class="push"></div>

<div style="display: none;">
    <div id="joinClub" class="popup-confirm popup">
        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close"><span class="tip">Закрыть</span></a>
        <div class="confirm-before">
            <div class="confirm-question">
                <p>Чтобы размещать материалы и добавлять<br/>комментарии, Вы должны вступить в клуб!</p>
            </div>
            <div class="bottom">
                <a href="javascript:void(0);" class="btn btn-gray-medium" onclick="$.fancybox.close();"><span><span>Отменить</span></span></a>
                <?=HHtml::link('<span><span>Вступить в клуб</span></span>', array('community/join', 'action' => 'join', 'community_id' => $this->community->id), array('class' => 'btn btn-green-medium joinButton'), true)?>
            </div>
        </div>
        <div class="confirm-after">
        </div>
    </div>
</div>

<?php $this->endContent(); ?>