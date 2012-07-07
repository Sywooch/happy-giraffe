var Login = {
    step:1,
    rememberPassword:function (email, code, password) {
        if (typeof email == "undefined")
            email = $('#User_email').val();
        $.post(base_url + '/site/rememberPassword/step/' + this.step + '/', {email:email, code:code, password:password}, function (data) {
            $.fancybox.open(data);
            $('#rps-form').submit(function () {
                var code = $('#User_remember_code').size() > 0 ? $('#User_remember_code').val() : null;
                var password = $('#User_new_password').size() > 0 ? $('#User_new_password').val() : null;
                Login.rememberPassword($('#User_remember_email').val(), code, password);
                return false;
            });
        }, 'html');
    }
}
