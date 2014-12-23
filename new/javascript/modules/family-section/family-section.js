define(['jquery', 'knockout', 'text!family-section/family-section.html', 'models/Family', 'models/FamilyMember'], function FamilyUserViewModelHandler($, ko, template, Family, FamilyMember) {
    function FamilySection(params) {
        this.family = Object.create(Family);
        this.membersArray = ko.observableArray();
        this.loadingFamily = ko.observable(true);
        this.familyHandler = function familyHandler(familyData) {
            if (familyData.success === true) {
                if (familyData.data !== undefined) {
                    console.log(familyData);
                    this.family.init(familyData.data);
                    this.loadingFamily(false);
                }
            }
        };
        this.family.get(true).done(this.familyHandler.bind(this));
    }

    return {
        viewModel: FamilySection,
        template: template
    };
});