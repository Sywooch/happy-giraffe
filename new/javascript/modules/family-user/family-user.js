define(['jquery', 'knockout', 'text!family-user/family-user.html', 'models/Family'], function FamilyUserViewModelHandler($, ko, template, Family) {

    function FamilyUserViewModel() {
        this.family = Object.create(Family);
        this.membersArray = ko.observableArray();
        this.addFamilyMember = function addFamilyMember() {
            this.membersArray.push(1);
        };
        this.addFamilyPhoto = function addFamilyPhoto() {

        };
        this.addFamilyDescription = function addFamilyDescription() {

        };
        this.familyHandler = function familyHandler(familyData) {
            if (familyData.success === true) {
              if (familyData.data !== undefined) {
                  this.family.init(familyData.data);
              }
            }
        };
        this.createFamilyHandler = function createFamilyHandler(familyData) {
            if (familyData.success === true) {
                this.family.init(familyData.data);
            }
        };
        this.family.get(true).done(this.familyHandler);
    }

    return {
        viewModel: FamilyUserViewModel,
        template: template
    };

});