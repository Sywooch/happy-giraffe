define(['jquery', 'knockout', 'text!family-user/family-user.html', 'models/Family', 'models/FamilyMember', 'ko_photoUpload', 'ko_library'], function FamilyUserViewModelHandler($, ko, template, Family, FamilyMember) {

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
            ko.applyBindings({}, $('photo-uploader-form')[0]);
        };
        this.addFamilyDescription = function addFamilyDescription() {
            this.family.description.editing(true);
        };
        this.familyHandler = function familyHandler(familyData) {
            if (familyData.success === true) {
              if (familyData.data !== undefined) {
                  this.family.init(familyData.data);
                  this.loadingFamily(false);
              } else {
                  this.createFamily();
                  this.loadingFamily(false);
              }
            }
        };
        this.createFamily = function createFamily() {
            return this.family.create().done(this.createFamilyHandler.bind(this));
        };
        this.createFamilyHandler = function createFamilyHandler(familyData) {
            if (familyData.success === true) {
                this.family.init(familyData.data);
                this.loadingFamily(false);
            }
        };
        this.removeMemberInstance = function removeMemberInstance(data, event) {
            var removed = this.family.members.splice(data.index(), 1);
        };
        this.closeFamilyDescription = function closeFamilyDescription(data, event) {
            this.family.description.editing(false);
        };
        this.removeFamilyDescription = function removeFamilyDescription (data, event) {
            this.family.description.editing(false);
            this.family.description.value(null);
            this.family.update({ description: this.family.description.value() });
        };
        this.submitFamilyDescription = function submitFamilyDescription(data, event) {
            this.family.description.editing(false);
            this.family.update({ description: this.family.description.value() });
        };
        this.family.get(true).done(this.familyHandler.bind(this));
    }

    return {
        viewModel: FamilyUserViewModel,
        template: template
    };

});