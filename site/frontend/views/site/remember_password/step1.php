<div class="popup">
    <a class="popup-close" onclick="$.fancybox.close();" href="javascript:void(0);"><span class="tip">Закрыть</span></a>
    <div class="popup-title">Восстановление пароля</div>
    <form id="rps-form" action="" method="post">
        <div class="form">
            <div class="row">
                <div class="row-title">Ваш e-mail:</div>
                <div class="row-elements"><input type="text" id="User_remember_email" name="User[email]" value="<?php echo $email; ?>" /></div>
            </div>
            <?php if(isset($error)): ?>
                <p class="errorMessage"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="login-btn">
                <button class="btn btn-green-arrow-big"><span><span>Продолжить</span></span></button>
            </div>
        </div>
    </form>
    <script type="text/javascript">Login.step = 2;</script>
</div>