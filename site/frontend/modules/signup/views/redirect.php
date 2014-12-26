<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
        document.domain = document.domain;
//        require = window.opener.require
//        registerForm = window.opener.registerForm;
        window.opener.require(['signup/register-form'], function (Register) {
            registerForm = new Register.viewModel();
            registerForm.social(<?=CJSON::encode($this->params['attributes'])?>);
            registerForm.__proto__.open(registerForm);
        });
//        registerForm = window.opener.registerForm;
//        console.log(registerForm);
        <?php if ($this->params['fromLogin']): ?>
//        registerForm.prototype.open();
        <?php endif; ?>
//        registerForm.social(<?//=CJSON::encode($this->params['attributes'])?>//)
        window.close();
    </script>
</head>
</html>