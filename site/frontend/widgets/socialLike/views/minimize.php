<div class="like-block fast-like-block">

    <div class="col-1">
        <script charset="utf-8" src="//yandex.st/share/share.js" type="text/javascript"></script>
        Поделиться
        <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
        <div id="ya_share1"></div>
        <script type="text/javascript">
            new Ya.share({
                element: 'ya_share1',
                l10n : 'ru',
                title : '<?php echo $this->options['title'] ?>',
                description : '<?php echo $this->options['description'] ?>',
                image : '<?php echo $this->options['image'] ?>',
                elementStyle : {
                    'type': 'none',
                    'quickServices' : ['vkontakte', 'facebook', 'twitter', 'odnoklassniki', 'moimir', 'gplus']
                }
            });
        </script>
    </div>

    <div class="col-2">

        <?php
        $this->render('_yh_min', array(
            'options' => $this->providers['yh'],
        ));
        ?>
    </div>

    <div class="col-3">
        <div class="rating"><span><?php echo Rating::model()->countByEntity($this->model, false) ?></span></div>
        <?php if ($this->notice != ''): ?>
        <div class="icon-info">
            <div class="tip">
                <?php echo $this->notice; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

</div>