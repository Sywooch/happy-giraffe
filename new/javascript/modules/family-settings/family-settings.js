define(['jquery', 'knockout', 'text!family-settings/family-settings.html', 'models/Family', 'models/FamilyMember'], function FamilySettingsViewModelHandler($, ko, template, Family, FamilyMember) {
    function FamilySettingsViewModel(params) {
        this.family = params.family;
        this.familyMember = Object.create(FamilyMember);
        this.familyMember = this.familyMember.init();
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
    }

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