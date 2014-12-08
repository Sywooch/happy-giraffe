define(['jquery', 'knockout', 'text!family-settings/family-settings.html', 'models/Model', 'models/Family', 'models/FamilyMember', 'ko_photoUpload', 'ko_library'], function FamilySettingsViewModelHandler($, ko, template, Model, Family, FamilyMember) {
    function FamilySettingsViewModel(params) {
        this.family = params.family;
        this.familyMember = params.member;
        this.index = params.index;
        this.days = DateRange.days();
        this.months = DateRange.months();
        this.years = DateRange.years(1920, 2015);
        this.genderArrayTwo = [{id: this.familyMember.genderTypes.woman, name: 'Дочь'}, {id: this.familyMember.genderTypes.men, name: 'Сын'}];
        this.genderArrayThree = [{id: this.familyMember.genderTypes.none, name: 'Пока не знаем'}, {id: this.familyMember.genderTypes.woman, name: 'Дочь'}, {id: this.familyMember.genderTypes.men, name: 'Сын'}];
        this.planingArray = [{id: this.familyMember.planningTypes.soon, name: 'В ближайшее время'}, {id: this.familyMember.planningTypes.next3years, name: 'В ближайшие 3 года'}];
        this.relationshipArray = [{id: this.familyMember.relationshipStatuses.friends, name: 'Друзья'}, {id: this.familyMember.relationshipStatuses.engaged, name: 'Обручены'}, {id: this.familyMember.relationshipStatuses.married, name: 'Женаты'}];
        this.createMember = function createMember(memberType) {
            this.familyMember.type.value(FamilyMember.memberTypes[memberType].name);
            initSelect2();
        };
        this.addPhoto = function addPhoto() {
            ko.applyBindings({}, $('photo-uploader-form')[0]);
        };
        this.findSelectName = function findSelectName(id, array) {
            for (var i = 0; i < array.length; i++) {
                if (id === array[i].id) {
                    return array[i].name;
                }
            }
        };
        this.beginEditField = function beginEditField(data, event) {
           data.editing(true);
           initSelect2();
        };
        this.createFamilyHandler = function createFamilyHandler(familyData) {
            if (familyData.success === true) {
                this.family.init(familyData.data);
                var attributes = Model.checkFieldsToPass(this.familyMember.memberTypes[this.familyMember.type.value()].fields, this.familyMember);
                this.familyMember.createMember(attributes).done(this.submitMemberHandler.bind(this));
            }
        };
        this.endEditField = function endEditField(data, event) {
            var attribute = {};
                attribute[data.name] = data.value();
                this.familyMember.updateMember(attribute).done(this.familyMember.errorHandler.bind(this.familyMember));
                data.editing(false);
        };
        this.submitMemberHandler = function submitMemberHandler(familyMemberData) {
            if (familyMemberData.success === true) {
                this.familyMember.updateModel(familyMemberData.data);
            }
            this.familyMember.errorHandler(familyMemberData);
        };
        this.submitMember = function submitMember() {
            var attributes = Model.checkFieldsToPass(this.familyMember.memberTypes[this.familyMember.type.value()].fields, this.familyMember);
            if (this.family.id() === null) {
                this.family.create().done(this.createFamilyHandler.bind(this));
            } else {
                this.familyMember.createMember(attributes).done(this.submitMemberHandler.bind(this));
            }
        };
    };

    function initSelect2() {
        // Измененный tag select
        $("select.select-cus__search-off").select2({
            width: '100%',
            minimumResultsForSearch: -1,
            dropdownCssClass: 'select2-drop__search-off',
            escapeMarkup: function(m) { return m; }
        });
    };

    return {
        viewModel: FamilySettingsViewModel,
        template: template
    };
});