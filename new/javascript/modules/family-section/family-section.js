define(['jquery', 'knockout', 'text!family-section/family-section.html', 'models/Model', 'models/Family', 'models/FamilyMember'], function FamilyUserViewModelHandler($, ko, template, Model, Family, FamilyMember) {
    function FamilySection(params) {
        this.family = Object.create(Family);
        this.family.userId = params.userId;
        this.membersArray = ko.observableArray();
        this.loadingFamily = ko.observable(true);
        this.editUrl = '/user/' + this.family.userId + '/family/edit/';
        this.familyUrl = '/user/' + this.family.userId + '/family/';
        this.rightsForManipulation = Model.checkRights(params.userId);
        this.familyHandler = function familyHandler(familyData) {
            if (familyData.success === true) {
                if (familyData.data !== undefined) {
                    this.family.init(familyData.data);
                }
                this.loadingFamily(false);
            }
        };
        this.family.get(true).done(this.familyHandler.bind(this));
    }

    return {
        viewModel: FamilySection,
        template: template
    };
});