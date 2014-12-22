define(['jquery', 'knockout', 'text!signup/register-form.html', 'models/User'], function($, ko, template, User) {
    function RegisterForm(params) {
        this.user = Object.create(User).init(params.attributes);
        this.open = function open() {

        }
    }

    return {
        viewModel: RegisterForm,
        template: template
    };
});
