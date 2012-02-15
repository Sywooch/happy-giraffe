<div class="like-block clearfix">
    <div class="tip">
        <div class="container">
            <i class="icon-question"></i>

            <div class="text">
                <big><?php echo $this->title; ?></big>

                <p>Как правило, кроватку новорождому приобретают незадолго до его появления на свет. При этом многие
                    молодые родители обращают внимание главным образом на ее внешний вид.</p>

                <p>Как правило, кроватку новорождому приобретают незадолго до его появления на свет. При этом многие
                    молодые родители обращают внимание главным образом на ее внешний вид.</p>
            </div>
        </div>
    </div>

    <div class="clearfix">
        <div class="title">Вам полезна статья? Отметь!</div>
    </div>

    <div class="like-buttons">
        <?php
        $this->render('_yh', array(
            'options' => $this->providers['yh'],
        ));
        ?>
        <div class="other-likes">
            <ul>
                <li><?php $this->render('_ok', array($this->providers['ok'])); ?></li>
                <li style="text-align:center;"><?php $this->render('_gp', array($this->providers['gp'])); ?></li>
                <li><?php $this->render('_vk', array($this->providers['vk'])); ?></li>
                <li><?php $this->render('_mr', array($this->providers['mr'])); ?></li>
                <li style="text-align:center;"><?php $this->render('_tw', array($this->providers['tw'])); ?></li>
                <li style="text-align:right;"><?php $this->render('_fb', array($this->providers['fb'])); ?></li>
            </ul>
        </div>
    </div>

    <div class="rating">
        <span><?php echo Rating::countByEntity($this->model) ?></span><br/>рейтинг
    </div>

</div>
