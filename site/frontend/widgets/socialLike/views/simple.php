<?php if (get_class($this->model) == 'ContestWork'): ?>


    <div class="like-block fast-like-block">
        <?php if ($this->model->contest->status == Contest::STATUS_ACTIVE): ?>
            <div class="box-1 auth-services">

                <?php
                    Yii::app()->eauth->renderWidget(array(
                        'action' => '/ajax/socialVote',
                        'params' => array(
                            'entity' => get_class($this->model),
                            'entity_id' => $this->model->id,
                            'model' => $this->model
                        ),
                        'mode' => 'vote',
                        'predefinedServices' => array('facebook' => 'facebook', 'vkontakte' => 'vkontakte', 'odnoklassniki', 'twitter'),
                    ));
                ?>

            </div>
        <?php endif; ?>

    </div>
<?php else: ?>

    <?php

    if (get_class($this->model) == 'ContestWork' && Yii::app()->request->isAjaxRequest) {
        $attach = AttachPhoto::model()->findByEntity('ContestWork', $this->model->id);
        $photo = $attach[0]->photo;
        $url = Yii::app()->createAbsoluteUrl('albums/singlePhoto', array('entity' => 'Contest', 'contest_id' => $this->model->contest_id, 'photo_id' => $photo->id));
    } elseif(method_exists($this->model, 'isValentinePost') && $this->model->isValentinePost()){
        //костыль для валентина 2
        $url = $this->model->getUrl(false, true);
    } else {
        $url = $this->model->getUrl(false, true);
        //$url = 'http://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }

    $js = "
        if (typeof VK != 'undefined')
            $('.vk_share_button').html(VK.Share.button('".$url."',{type: 'round', text: 'Мне нравится'}));
    ";

    Yii::app()->clientScript
        ->registerScriptFile('http://vk.com/js/api/share.js?11')
        ->registerMetaTag($this->options['title'], null, null, array('property' => 'og:title'))
        ->registerMetaTag($this->options['image'], null, null, array('property' => 'og:image'))
        ->registerMetaTag($this->options['description'], null, null, array('property' => 'og:description'))
        ->registerMetaTag('article', null, null, array('property' => 'og:type'))
        ->registerMetaTag('Веселый Жираф', 'og:site_name')
        ->registerScript('vklike', $js);
    ;
    ?>
    <div class="custom-likes-b<?php if ((get_class($this->model) != 'CommunityContent' && get_class($this->model) != 'BlogContent') || in_array($this->model->type_id, array(CommunityContentType::TYPE_PHOTO, CommunityContentType::TYPE_STATUS))): ?> custom-likes-b__like-white<?php endif; ?>">
    <div class="custom-likes-b_slogan">Поделитесь с друзьями!</div>
    <div class="like-block fast-like-block">
        <div class="box-1">

            <div class="share_button">
                <div class="fb-custom-like">
                    <?=HHtml::link('<i class="icon-fb"></i>Мне нравится',
                        'http://www.facebook.com/sharer/sharer.php?u='.urlencode($url),
                        array('class'=>'fb-custom-text', 'onclick'=>'return Social.showFacebookPopup(this);'), true) ?>
                    <div class="fb-custom-share-count">0</div>
                    <script type="text/javascript">
                        $.getJSON("http://graph.facebook.com", { id:'<?=$url ?>' }, function (json) {
                            $('.fb-custom-share-count').html(json.shares || '0');
                        });
                    </script>
                </div>
            </div>

            <div class="share_button">
                <div class="vk_share_button"></div>
            </div>

            <div class="share_button">
                <div id="ok_shareWidget" style="height: 22px;"></div>
                <script>
                    !function (d, id, did, st) {
                        var js = d.createElement("script");
                        js.src = "http://connect.ok.ru/connect.js";
                        js.onload = js.onreadystatechange = function () {
                            if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
                                if (!this.executed) {
                                    this.executed = true;
                                    setTimeout(function () {
                                        OK.CONNECT.insertShareWidget(id,did,st);
                                    }, 0);
                                }
                            }};
                        d.documentElement.appendChild(js);
                    }(document,"ok_shareWidget","<?=$url ?>","{width:145,height:35,st:'straight',sz:20,ck:1}");
                </script>
            </div>

            <div class="share_button">
                <div class="tw_share_button">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru" data-url="<?=$url?>">Твитнуть</a>
                    <script type="text/javascript" charset="utf-8">
                        if (typeof twttr == 'undefined')
                            window.twttr = (function (d, s, id) {
                                var t, js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//platform.twitter.com/widgets.js";
                                fjs.parentNode.insertBefore(js, fjs);
                                return window.twttr || (t = { _e:[], ready:function (f) {
                                    t._e.push(f)
                                } });
                            }(document, "script", "twitter-wjs"));
                    </script>
                </div>
            </div>
            <script type="text/javascript">
                $(function () {
                    //подписываемся на клик
                    if (typeof VK !== 'undefined' && VK.Share && VK.Share.click) {
                        var oldShareClick = VK.Share.click;
                        VK.Share.click = function (index, el) {
                            Social.updateLikesCount('vk');
                            return oldShareClick.call(VK.Share, index, el);
                        }
                    }

                    twttr.ready(function (twttr) {
                        twttr.events.bind('tweet', function (event) {
                            console.log('tweet');
                            Social.updateLikesCount("tw")
                        });
                    });
                });
            </script>
        </div>
    </div>
    </div>

    <?php if (!Yii::app()->user->isGuest && Yii::app()->user->model->group != UserGroup::USER && Yii::app()->user->checkAccess('commentator_panel')):?>
        <script type="text/javascript">
            $(function () {
                $('body').delegate('.share_button a.fb-custom-text', 'click',function () {
                    $.post('/ajaxSimple/commentatorLike/', {
                        social_id: 1,
                        entity: '<?=get_class($this->model) ?>',
                        entity_id: <?=$this->model->id ?>
                    });
                }).delegate('.share_button div.vk_share_button a', 'click', function () {
                        $.post('/ajaxSimple/commentatorLike/', {
                            social_id: 2,
                            entity: '<?=get_class($this->model) ?>',
                            entity_id: <?=$this->model->id ?>
                        });
                    });
            });
        </script>
    <?php endif ?>

<?php endif; ?>