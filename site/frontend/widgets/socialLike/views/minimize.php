<div class="like-block fast-like-block">

    <div class="box-1">
        Поделиться
        <?php if(!Yii::app()->request->isAjaxRequest): ?>
            <script charset="utf-8" src="//yandex.st/share/share.js" type="text/javascript"></script>
        <?php endif; ?>
        <div id="ya_share1"></div>
        <script type="text/javascript">
            new Ya.share({
                element: 'ya_share1',
                l10n : 'ru',
                title : <?= CJavaScript::encode($this->options['title']) ?>,
                description : <?= CJavaScript::encode($this->options['description']) ?>,
                image : <?= CJavaScript::encode($this->options['image']) ?>,
                elementStyle : {
                    'type': 'none',
                    'quickServices' : ['vkontakte', 'facebook', 'twitter', 'odnoklassniki', 'moimir', 'gplus']
                }
            });
        </script>
    </div>

    <div class="box-2">

        <?php
        $this->render('_yh_min', array(
            'options' => $this->providers['yh'],
        ));
        ?>
    </div>

    <div class="box-3">
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