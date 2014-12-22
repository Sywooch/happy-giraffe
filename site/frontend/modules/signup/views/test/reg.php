<a  data-bind="login: {}" id="href">Регистрация</a>

<script type="text/javascript">
    require(['knockout', 'signup/login-binding'], function(ko) {
        ko.applyBindings({}, document.getElementById('href'));
    });
</script>