<div class="box homepage-auth">
    <?php if (Yii::app()->user->isGuest):?>
        <div class="t">
            <p><span>Веселый жираф</span> - это интернет-сообщество, где мамы и папы встречаются каждый день, чтобы общаться, делиться советами, находить новых друзей и многое другое.</p>
            <div class="gray"><b>Это полезно, это интересно и это очень весело!</b></div>
        </div>

        <div class="b">
            <?=HHtml::link('', '#register', array('class' => 'register fancy'))?>
            <br>
            <small>Уже зарегистрированы?</small> &nbsp; <a class="fancy" rel="nofollow" href="#login">Войти</a>
        </div>
    <?php else: ?>
        <div class="t">
            <div class="hello">Привет,</div>
        </div>

        <div class="b">
            <div class="name"><?php echo CHtml::encode($this->user->first_name); ?></div>
        </div>
    <?php endif ?>
</div>