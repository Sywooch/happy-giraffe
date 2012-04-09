<div class="fast-like-block">

    <div class="col-1">
        <script charset="utf-8" src="//yandex.st/share/share.js" type="text/javascript"></script>
        Поделиться
        <div data-yasharequickservices="vkontakte,facebook,twitter,odnoklassniki,moimir,gplus" data-yasharetype="none"
             data-yasharel10n="ru" class="yashare-auto-init"><span class="b-share"><a data-service="vkontakte"
                                                                                      href="http://share.yandex.ru/go.xml?service=vkontakte&amp;url=http%3A%2F%2Fdev.happy-giraffe.ru%2Fhtml%2Fsocial%2Farticle_2.0.html&amp;title=Untitled%20Document"
                                                                                      class="b-share__handle b-share__link"
                                                                                      title="ВКонтакте" target="_blank"
                                                                                      rel="nofollow"><span
            class="b-share-icon b-share-icon_vkontakte"></span></a><a data-service="facebook"
                                                                      href="http://share.yandex.ru/go.xml?service=facebook&amp;url=http%3A%2F%2Fdev.happy-giraffe.ru%2Fhtml%2Fsocial%2Farticle_2.0.html&amp;title=Untitled%20Document"
                                                                      class="b-share__handle b-share__link"
                                                                      title="Facebook" target="_blank"
                                                                      rel="nofollow"><span
            class="b-share-icon b-share-icon_facebook"></span></a><a data-service="twitter"
                                                                     href="http://share.yandex.ru/go.xml?service=twitter&amp;url=http%3A%2F%2Fdev.happy-giraffe.ru%2Fhtml%2Fsocial%2Farticle_2.0.html&amp;title=Untitled%20Document"
                                                                     class="b-share__handle b-share__link"
                                                                     title="Twitter" target="_blank"
                                                                     rel="nofollow"><span
            class="b-share-icon b-share-icon_twitter"></span></a><a data-service="odnoklassniki"
                                                                    href="http://share.yandex.ru/go.xml?service=odnoklassniki&amp;url=http%3A%2F%2Fdev.happy-giraffe.ru%2Fhtml%2Fsocial%2Farticle_2.0.html&amp;title=Untitled%20Document"
                                                                    class="b-share__handle b-share__link"
                                                                    title="Одноклассники" target="_blank"
                                                                    rel="nofollow"><span
            class="b-share-icon b-share-icon_odnoklassniki"></span></a><a data-service="moimir"
                                                                          href="http://share.yandex.ru/go.xml?service=moimir&amp;url=http%3A%2F%2Fdev.happy-giraffe.ru%2Fhtml%2Fsocial%2Farticle_2.0.html&amp;title=Untitled%20Document"
                                                                          class="b-share__handle b-share__link"
                                                                          title="Мой Мир" target="_blank"
                                                                          rel="nofollow"><span
            class="b-share-icon b-share-icon_moimir"></span></a><a data-service="gplus"
                                                                   href="http://share.yandex.ru/go.xml?service=gplus&amp;url=http%3A%2F%2Fdev.happy-giraffe.ru%2Fhtml%2Fsocial%2Farticle_2.0.html&amp;title=Untitled%20Document"
                                                                   class="b-share__handle b-share__link"
                                                                   title="Google Plus" target="_blank"
                                                                   rel="nofollow"><span
            class="b-share-icon b-share-icon_gplus"></span></a></span></div>
    </div>

    <div class="col-2">

        <?php
        $this->render('_yh_min', array(
            'options' => $this->providers['yh'],
        ));
        ?>
    </div>

    <div class="col-3">
        <div class="rating"><?php echo Rating::model()->countByEntity($this->model, false) ?></div>
        <?php if ($this->notice != ''): ?>
        <div class="icon-info">
            <div class="tip">
                <?php echo $this->notice; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

</div>