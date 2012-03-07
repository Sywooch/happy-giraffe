<?php $this->beginContent('//layouts/main'); ?>

<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('body').delegate('a.joinButton', 'click', function(e) {
            e.preventDefault();

            $.ajax({
                dataType: 'JSON',
                url: $(this).attr('href'),
                success: function(response) {
                    if (response.status) {
                        $('a.club-join-btn').replaceWith(response.button);
                        $.fancybox.close();
                    }
                },
                context: $(this)
            });
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

            <div class="club-fast-nav">

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
                            'label' => 'Статью',
                            'url' => $this->getUrl(array('content_type_slug' => 'post')),
                            'active' => $this->content_type_slug == 'post',
                            'linkOptions' => array(
                                'rel' => 'nofollow',
                            ),
                        ),
                        array(
                            'label' => 'Путешествие',
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
            <a href="" class="btn btn-green"><span><span>Добавить</span></span></a>
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array(
                        'label' => 'Статью',
                        'url' => $this->getUrl(array('content_type_slug' => 'post'), 'community/add'),
                    ),
                    array(
                        'label' => 'Путешествие',
                        'url' => array('community/addTravel'),
                        'visible' => $this->community->id == 21,
                    ),
                    array(
                        'label' => 'Видео',
                        'url' => $this->getUrl(array('content_type_slug' => 'video'), 'community/add'),
                    ),
                ),
            ));
            ?>
        </div>

        <div class="club-topics-list">
            <?php
                if (!Yii::app()->authManager->checkAccess('editCommunityRubric', Yii::app()->user->getId())) {
                    $items = array();
                    foreach ($this->community->rubrics as $r) {
                        $items[] = array(
                            'label' => $r->name,
                            'url' => $this->getUrl(array('rubric_id' => $r->id)),
                            'active' => $r->id == $this->rubric_id,
                        );
                    }

                    $this->widget('zii.widgets.CMenu', array(
                            'items' => $items,
                        )
                    );
                } else {
                    //for moderators
                    $this->renderPartial('parts/rubrics',array(
                        'community'=>$this->community,
                        'content_type_slug'=>$this->content_type_slug,
                        'current_rubric'=>$this->rubric_id
                    ));
                }
            ?>
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