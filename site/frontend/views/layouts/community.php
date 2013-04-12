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
                        $this->widget('HMenu', array(
                            'seoHide' => true,
                            'items' => array(
                                array(
                                    'label' => 'Все',
                                    'url' => $this->getUrl(array('content_type_slug' => null)),
                                    'active' => $this->content_type_slug === null,
                                ),
                                array(
                                    'label' => 'Статьи',
                                    'url' => $this->getUrl(array('content_type_slug' => 'post')),
                                    'active' => $this->content_type_slug == 'post',
                                ),
                                array(
                                    'label' => 'Путешествия',
                                    'url' => $this->getUrl(array('content_type_slug' => 'travel')),
                                    'active' => $this->content_type_slug == 'travel',
                                    'visible' => $this->community->id == 21,
                                ),
                                array(
                                    'label' => 'Видео',
                                    'url' => $this->getUrl(array('content_type_slug' => 'video')),
                                    'active' => $this->content_type_slug == 'video',
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
                <?=CHtml::link('<span class="big">Добавить</span><span class="small">запись в клуб</span>', '#login', array('class' => 'btn-green twolines fancy', 'data-theme'=>'white-square'))?>
            <?php else: ?>
                <?=HHtml::link('<span class="big">Добавить</span><span class="small">запись в клуб</span>', $this->getUrl(array('content_type_slug' => null), 'community/add'), array('class' => 'btn-green twolines'), true)?>
            <?php endif ?>
        </div>

        <?php if (false): ?>
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
        <?php endif; ?>

        <?php if($this->beginCache('community-rubrics', array(
            'duration' => 600,
            'dependency' => array(
                'class' => 'CDbCacheDependency',
                'sql' => 'SELECT MAX(updated) FROM community__contents c
                    JOIN community__rubrics r ON c.rubric_id = r.id
                    WHERE r.community_id = ' . $this->community->id,
            ),
            'varyByParam' => array('community_id'),
            'varyByExpression' => $this->rubric_id,
        ))): ?>

            <div class="club-topics-list-new club-topics-list-new__bracket drop-holder">

                <?php
                    $items = array();

                    $items[] = array(
                        'label' => 'Все записи клуба',
                        'url' => $this->getUrl(array('rubric_id' => null)),
                        'template' => '<span>{menu}</span><div class="count">' . $this->community->getCount() . '</div>',
                        'active' => $this->rubric_id === null,
                    );

                    foreach ($this->community->rubrics as $rubric) {
                        if ($rubric->contentsCount > 0 && $rubric->parent_id === null) {
                            $item = array(
                                'label' => $rubric->title,
                                'url' => $this->getUrl(array('rubric_id' => $rubric->id)),
                                'template' => '<span>{menu}</span><div class="count">' . $rubric->contentsCount . '</div>',
                                'active' => $rubric->id == $this->rubric_id,
                            );

                            if ($rubric->childs) {
                                $childs = array();
                                $hasFullChilds = false;
                                foreach ($rubric->childs as $c) {
                                    if ($c->contentsCount > 0) {
                                        $hasFullChilds = true;

                                        $childs[] = array(
                                            'label' => $c->title,
                                            'url' => $this->getUrl(array('rubric_id' => $c->id)),
                                            'template' => '<span>{menu}</span><div class="count">' . $c->contentsCount . '</div>',
                                            'active' => $c->id == $this->rubric_id,
                                        );

                                        if ($c->id == $this->rubric_id) {
                                            $item['itemOptions'] = array(
                                                'class' => 'toggled active',
                                            );
                                        }
                                    }
                                }

                                if ($hasFullChilds) {
                                    $item['items'] = $childs;
                                    $item['template'] .= '<a href="javascript:void(0)" class="drop-activate-link" onclick="$(this).parents(\'li\').toggleClass(\'toggled\');"></a>';
                                    $item['submenuOptions'] = array('class' => 'club-topics-list-new-drop');
                                }
                            }

                            $items[] = $item;
                        }
                    }

                    $this->widget('zii.widgets.CMenu', array(
                        'items' => $items,
                    ));
                ?>

            </div>

            <?php if ($this->community->id == 24): ?>
                <div class="margin-b40">
                    <?php $this->renderPartial('/banners/community_24_240x400'); ?>
                </div>
            <?php endif; ?>

            <div class="recent-topics">

                <div class="title">Последние темы</div>

                <ul>
                    <?php foreach ($this->community->last as $c): ?>
                    <li><?=CHtml::link(CHtml::encode($c->title), $c->url)?></li>
                    <?php endforeach; ?>
                </ul>

            </div>

        <?php $this->endCache(); endif;  ?>

        <?php if (false): ?>
            <div class="box">
                <a href="<?=$this->createUrl('/contest/default/view', array('id' => 9)) ?>"><img
                    src="/images/contest/banner-w240-9-<?=mt_rand(1, 3)?>.jpg"></a>
            </div>
        <?php endif; ?>

        <?php foreach ($this->community->banners as $b): ?>
            <?php $this->renderPartial('_banner', array('data' => $b)); ?>
        <?php endforeach; ?>

        <?php if ($this->action->id == 'view' && false): ?>
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

<div style="display: none;">
    <div id="joinClub" class="popup-confirm popup">
        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close tooltip" title="Закрыть"></a>
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