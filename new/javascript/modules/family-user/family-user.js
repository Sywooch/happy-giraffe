define(['jquery', 'knockout', 'text!family-user/family-user.html', 'models/Family', 'models/FamilyMember'], function FamilyUserViewModelHandler($, ko, template, Family, FamilyMember) {

    function FamilyUserViewModel() {
        this.family = Object.create(Family);
        this.membersArray = ko.observableArray();
        this.loadingFamily = ko.observable(true);
        this.addFamilyMember = function addFamilyMember() {
            var familyMember = Object.create(FamilyMember);
                familyMember = familyMember.init();
            this.family.members.push(familyMember);
        };
        this.addFamilyPhoto = function addFamilyPhoto() {

        };
        this.addFamilyDescription = function addFamilyDescription() {

        };
        this.familyHandler = function familyHandler(familyData) {
            if (familyData.success === true) {
              if (familyData.data !== undefined) {
                  this.family.init(familyData.data);
                  this.loadingFamily(false);
              }
            }
        };
        this.createFamilyHandler = function createFamilyHandler(familyData) {
            if (familyData.success === true) {
                this.family.init(familyData.data);
            }
        };
        this.removeMemberInstance = function removeMemberInstance(data, event) {
            var removed = this.family.members.splice(data.index(), 1);
        };
        this.family.get(true).done(this.familyHandler.bind(this));
    }

    return {
        viewModel: FamilyUserViewModel,
        template: template
    };

});