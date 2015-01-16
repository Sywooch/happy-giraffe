<div id="href">
    <a class="registration-button" data-bind="follow: {}">Регистрация</a><br>
    <a class="login-button" data-bind="follow: {}">Вход</a>
</div>

<script type="text/javascript">
    require(['extensions/proceedAuthForms'], function RegLogRem(proceedAuthForms) {
        proceedAuthForms();
    });
//    require(['knockout', 'signup/register-form', 'signup/login-form', 'signup/password-recovery-form', 'signup/bindings'], function(ko, RegisterForm, LoginForm, PasswordRecoveryForm) {
//        ko.applyBindings(RegisterForm.viewModel.prototype, document.getElementById('register-button'));
//        ko.applyBindings(LoginForm.viewModel.prototype, document.getElementById('login-button'));
//        ko.applyBindings(PasswordRecoveryForm.viewModel.prototype, document.getElementById('password-recovery-form'));
//    });
</script>