define(['jquery', 'knockout', 'text!family-settings/family-settings.html', 'models/Family', 'models/FamilyMember'], function FamilySettingsViewModelHandler($, ko, template, Family, FamilyMember) {
    function FamilySettingsViewModel(params) {
        this.family = params.family;
        this.familyMember = params.member;
        this.index = params.index;
        this.days = DateRange.days();
        this.months = DateRange.months();
        this.years = DateRange.years(1920, 2014);
        this.genderArrayTwo = [{id: this.familyMember.genderTypes.woman, name: 'Дочь'}, {id: this.familyMember.genderTypes.men, name: 'Сын'}];
        this.genderArrayThree = [{id: this.familyMember.genderTypes.none, name: 'Пока не знаем'}, {id: this.familyMember.genderTypes.woman, name: 'Дочь'}, {id: this.familyMember.genderTypes.men, name: 'Сын'}];
        this.planingArray = [{id: this.familyMember.planningTypes.soon, name: 'В ближайшее время'}, {id: this.familyMember.planningTypes.next3years, name: 'В ближайшие 3 года'}];
        this.relationshipArray = [{id: this.familyMember.relationshipStatuses.friends, name: 'Друзья'}, {id: this.familyMember.relationshipStatuses.engaged, name: 'Обручены'}, {id: this.familyMember.relationshipStatuses.married, name: 'Женаты'}];
        this.createMember = function createMember(memberType) {
            this.familyMember.type.value(FamilyMember.memberTypes[memberType]);
        };
        this.beginEditField = function beginEditField(data, event) {
           data.editing(true);
           initSelect2();
        };
        this.endEditField = function endEditField(data, event) {
            data.editing(false);
        };
    };

    function initSelect2() {
        // Измененный tag select
        $(".select-cus__search-off").select2({
            width: '100%',
            minimumResultsForSearch: -1,
            dropdownCssClass: 'select2-drop__search-off',
            escapeMarkup: function(m) { return m; }
        });
        $(".select-cus__search-off .select2-search, .select-cus__search-off .select2-focusser").remove();
    };

    return {
        viewModel: FamilySettingsViewModel,
        template: template
    };
});