<div class="like-block clearfix">
    <div class="block-in">
        <?php if($this->notice != ''): ?>
            <div class="tip">
                <div class="container">
                    <i class="icon-question"></i>

                    <div class="text">
                        <?php echo $this->notice; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="clearfix">
            <div class="title"><?php echo $this->title; ?></div>
        </div>

        <div class="like-buttons clearfix">

            <div class="hg-like like-btn">
                <?php
                $this->render('_yh', array(
                    'options' => $this->providers['yh'],
                ));
                ?>
            </div>

            <div class="other-likes">
                <ul class="">
                    <li><div class="like-btn"><?php $this->render('_vk', array($this->providers['vk'])); ?></div></li>
                    <li><div class="like-btn"><?php $this->render('_gp', array($this->providers['gp'])); ?></div></li>
                    <li><div class="like-btn"><?php $this->render('_mr', array($this->providers['mr'])); ?></div></li>
                    <li><div class="like-btn"><?php $this->render('_fb', array($this->providers['fb'])); ?></div></li>
                    <li><div class="like-btn"><?php $this->render('_tw', array($this->providers['tw'])); ?></div></li>
                    <!--<li><div class="like-btn"><?php /*$this->render('_ok', array($this->providers['ok'])); */?></div></li>-->
                </ul>
            </div>
        </div>

        <div class="rating">
            <span><?php echo Rating::model()->countByEntity($this->model, false) ?></span><br/>рейтинг
        </div>
    </div>
</div>
