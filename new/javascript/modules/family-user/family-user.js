define(['jquery', 'knockout', 'text!family-user/family-user.html', 'models/Family'], function ($, ko, template, Family) {

    function FamilyUserViewModel() {
        this.family = Object.create(Family);
        this.familyHandler = function familyHandler(data) {
          console.log(data);
        };
        this.family.get(true).done(this.familyHandler);
    }

    return {
        viewModel: FamilyUserViewModel,
        template: template
    };

});