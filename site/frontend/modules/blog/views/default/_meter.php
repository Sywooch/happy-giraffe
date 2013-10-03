<?php
/**
 * @var CommunityContestWork @contestWork
 */
?>

<div class="contest-meter">
    <div class="contest-meter_count">
        <div class="contest-meter_count-num"><?=$contestWork->rate?></div>
        <div class="contest-meter_count-tx">баллов</div>
    </div>
    <a href="" class="contest-meter_a-vote">Голосовать</a>
    <div class="contest-meter_vote">
        <div class="contest-meter_vote-tx">Вы можете проголосовать за участника нажав на кнопки соцсетей</div>
        <div class="contest-meter_vote-hold">
            <div class="like-block fast-like-block">

                <div class="box-1">
                    <div class="share_button">
                        <div class="fb-custom-like">
                            <a href="http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fdev.happy-giraffe.ru%2Fuser%2F13217%2Fblog%2Fpost22589%2F" onclick="return Social.showFacebookPopup(this);" class="fb-custom-text">
                                <i class="pluginButtonIcon img sp_like sx_like_fav"></i>Мне нравится</a>
                            <div class="fb-custom-share-count">0</div>
                            <script type="text/javascript">
                                $.getJSON("http://graph.facebook.com", { id : document.location.href }, function(json){
                                    $('.fb-custom-share-count').html(json.shares || '0');
                                });
                            </script>
                        </div>
                    </div>

                    <div class="share_button">
                        <div class="vk_share_button"></div>
                    </div>

                    <div class="share_button">
                        <a class="odkl-klass-oc" href="http://dev.happy-giraffe.ru/user/13217/blog/post22589/" onclick="Social.updateLikesCount('ok'); ODKL.Share(this);return false;"><span>0</span></a>
                    </div>

                    <div class="share_button">
                        <div class="tw_share_button">
                            <iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.1380751370.html#_=1380784704031&amp;count=horizontal&amp;id=twitter-widget-0&amp;lang=ru&amp;original_referer=http%3A%2F%2F109.87.248.203%2Fhtml%2Fsocial%2Fclubs%2Fclub-contest-photo.php&amp;size=m&amp;text=Happy%20Giraffe&amp;url=http%3A%2F%2Fdev.happy-giraffe.ru%2Fuser%2F13217%2Fblog%2Fpost22589%2F" class="twitter-share-button twitter-count-horizontal" title="Twitter Tweet Button" data-twttr-rendered="true" style="width: 139px; height: 20px;"></iframe>
                            <script type="text/javascript" charset="utf-8">
                                if (typeof twttr == 'undefined')
                                    window.twttr = (function (d,s,id) {
                                        var t, js, fjs = d.getElementsByTagName(s)[0];
                                        if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
                                        js.src="//platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
                                        return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
                                    }(document, "script", "twitter-wjs"));
                            </script>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>