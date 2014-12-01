define(['knockout', 'models/Model', 'models/User', 'models/Family', 'user-config'], function FamilyMemberModel(ko, Model, User, Family, userConfig) {
    var FamilyMember = {
        createMemberUrl: '/api/family/createMember/',
        updateMemberUrl: '/api/family/updateMember/',
        removeMemberUrl: '/api/family/removeMember/',
        restoreMemberUrl: '/api/family/restoreMember/',
        memberTypes: {
            adult: 'adult',
            child: 'child',
            waiting: 'waiting',
            planning: 'planning'
        },
        genderTypes: {
            woman: '0',
            men: '1',
            twins: '2',
            none: 'null'
        },
        planningTypes: {
            soon: 'soon',
            next3years: 'next3years'
        },
        relationshipStatuses: {
            friends: 'friends',
            engaged: 'engaged',
            married: 'married'
        },
        createMember: function createMember(attribObj) {
           return Model.get(this.createMemberUrl, { attributes: attribObj });
        },
        updateMember: function updateMember(attribObj) {
            return Model.get(this.updateMemberUrl, { id: this.id(), attributes: attribObj });
        },
        removeMember: function removeMember() {
            return Model.get(this.removeMemberUrl, { id: this.id() });
        },
        restoreMember: function restoreMember() {
            return Model.get(this.removeMemberUrl, { id: this.id() });
        },
        init: function init(data) {
            data = (data === undefined) ? {} : data;
            this.id = ko.observable(data.id || null);
            this.type = Model.createStdProperty(data.type || null);
            this.relationshipStatus = Model.createStdProperty(data.relationshipStatus || null);
            this.gender = Model.createStdProperty(data.gender || null);
            this.name = Model.createStdProperty(data.name || null);
            this.description = Model.createStdProperty(data.description || null);
            this.birthday = Model.createStdProperty(data.birthday || {});
            this.birthday.day = ko.observable((data.birthday !== undefined) ? data.birthday.day : null);
            this.birthday.month = ko.observable((data.birthday !== undefined) ? data.birthday.month : null);
            this.birthday.year = ko.observable((data.birthday !== undefined) ? data.birthday.year : null);
            this.birthday.value = ko.computed(function () {
               return this.year() + '-' +  this.month() + '-' + this.day();
            }, this.birthday);
            this.ageString = Model.createStdProperty(data.ageString || null);
            this.pregnancyTerm = Model.createStdProperty(data.pregnancyTerm || {});
            this.pregnancyTerm.day = ko.observable((data.pregnancyTerm !== undefined) ? data.pregnancyTerm.day : null);
            this.pregnancyTerm.month = ko.observable((data.pregnancyTerm !== undefined) ? data.pregnancyTerm.month : null);
            this.pregnancyTerm.year = ko.observable((data.pregnancyTerm !== undefined) ? data.pregnancyTerm.year : null);
            this.pregnancyTerm.value = ko.computed(function () {
                return this.year() + '-' +  this.month() + '-' + this.day();
            }, this.pregnancyTerm);
            this.planningWhen = Model.createStdProperty(data.planningWhen || null);
            return this;
        }

    };
    return FamilyMember;
});