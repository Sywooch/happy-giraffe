<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
        document.domain = document.domain;

        window.opener.require(['signup/register-social-form'], function (RegisterSocial) {
//                window.opener.console.log(RegisterSocial.test);

//            var model = new RegisterSocial(<?//=CJSON::encode($this->params)?>//);
//            model.open();

            //window.opener.console.log(RegisterSocial.viewModel.open);

            RegisterSocial.viewModel.open(<?=CJSON::encode($this->params)?>);

            //registerForm = new RegisterSocial.viewModel();
            //RegisterSocial.viewModel.__proto__.open();
        });


        <?php if (false): ?>
        var attributes = <?=CJSON::encode($this->params['attributes'])?>;
        if (typeof window.opener.registerForm === 'undefined') {
            window.opener.require(['signup/register-form'], function (Register) {
                registerForm = new Register.viewModel();
                registerForm.social(attributes);
                registerForm.__proto__.open(registerForm);
                registerForm.submitSocial();
            });
        } else {
            registerForm = window.opener.registerForm;
            <?php if ($this->params['fromLogin']): ?>
            registerForm.prototype.open(registerForm);
            <?php endif; ?>
            registerForm.social(attributes);
            registerForm.submitSocial();
        }
        <?php endif; ?>


        window.close();
    </script>
</head>
</html>