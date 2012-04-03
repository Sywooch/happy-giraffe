<?php $this->beginContent('//layouts/main'); ?>

<?php
    $cs = Yii::app()->clientScript;
    $inCommunity = (!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('createClubPost', array('user'=>Yii::app()->user->getModel(),'community_id'=>$this->community->id)))?1:0;
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

                <?php
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
                ?>

                <?php if (! Yii::app()->user->isGuest): ?>
                    <?php $this->renderPartial('_joinButton', array(
                        'community_id' => $this->community->id,
                    )); ?>
                <?php endif; ?>

            </div>

            <?php echo $content; ?>

        </div>
    </div>

    <div class="side-left">

        <div class="club-fast-add">
            <a href="<?=$this->getUrl(array('content_type_slug' => null), 'community/add')?>" class="btn btn-green"><span><span>Добавить</span></span></a>
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
                    <li><?=CHtml::link($c->name, $c->url)?></li>
                <?php endforeach; ?>
            </ul>

        </div>
    </div>
</div>

<div class="push"></div>

<div style="display: none;">
    <div id="joinClub" class="popup-confirm popup">
        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close">Закрыть</a>
        <div class="confirm-before">
            <div class="confirm-question">
                <p>Чтобы размещать материалы и добавлять<br/>комментарии, Вы должны вступить в клуб!</p>
            </div>
            <div class="bottom">
                <a href="javascript:void(0);" class="btn btn-gray-medium" onclick="$.fancybox.close();"><span><span>Отменить</span></span></a>
                <a href="<?php echo $this->createUrl('community/join', array('action' => 'join', 'community_id' => $this->community->id)); ?>" class="btn btn-green-medium joinButton"><span><span>Вступить в клуб</span></span></a>
            </div>
        </div>
        <div class="confirm-after">
        </div>
    </div>
</div>

<?php $this->endContent(); ?>