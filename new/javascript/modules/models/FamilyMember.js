define(['knockout', 'models/Model', 'models/User', 'models/Family', 'user-config', 'extensions/knockout.validation', 'extensions/validatorRules'], function FamilyMemberModel(ko, Model, User, Family, userConfig) {
    var FamilyMember = {
        createMemberUrl: '/api/family/createMember/',
        updateMemberUrl: '/api/family/updateMember/',
        removeMemberUrl: '/api/family/removeMember/',
        restoreMemberUrl: '/api/family/restoreMember/',
        memberTypes: {
            adult: {
                name: 'adult',
                fields: ['type', 'relationshipStatus', 'name', 'description']
            },
            child: {
                name: 'child',
                fields: ['type', 'gender', 'name', 'birthday', 'description']
            },
            waiting: {
                name: 'waiting',
                fields: ['type', 'gender', 'pregnancyTerm']
            },
            planning: {
                name: 'planning',
                fields: ['type', 'gender', 'planningWhen']
            }
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
            engagg: 'engaged',
            married: 'married'
        },
        createMember: function createMember(attribArray) {
           return Model.get(this.createMemberUrl, { attributes: attribArray });
        },
        updateMember: function updateMember(attribObj) {
            return Model.get(this.updateMemberUrl, { id: this.id(), attributes: [attribObj] });
        },
        removeMember: function removeMember() {
            return Model.get(this.removeMemberUrl, { id: this.id() });
        },
        restoreMember: function restoreMember() {
            return Model.get(this.removeMemberUrl, { id: this.id() });
        },
        canSubmit: function canSubmit() {
            var canSubmitFields;
            switch (this.type.value()) {
                case this.memberTypes.child.name:
                    this.name.value.extend({ mustFill: true });
                    this.birthday.day.extend({ dateMustFill: true });
                    this.birthday.month.extend({ dateMustFill: true });
                    this.birthday.year.extend({ dateMustFill: true });
                    this.gender.value.extend({ mustFill: true });
                    if (this.name.value.isValid() && this.birthday.day.isValid() && this.birthday.month.isValid() && this.birthday.year.isValid() && this.gender.value.isValid()) {
                        canSubmitFields = true;
                    } else {
                        canSubmitFields = false;
                    }
                    break;
                case this.memberTypes.adult.name:
                    this.name.value.extend({ mustFill: true });
                    this.relationshipStatus.value.extend({ mustFill: true });
                    if (this.name.value.isValid() && this.relationshipStatus.value.isValid()) {
                        canSubmitFields = true;
                    } else {
                        canSubmitFields = false;
                    }
                    break;
                case this.memberTypes.planning.name:
                    this.planningWhen.value.extend({ mustFill: true });
                    if (this.planningWhen.value.isValid()) {
                        canSubmitFields = true;
                    } else {
                        canSubmitFields = false;
                    }
                    break;
                case this.memberTypes.waiting.name:
                    this.pregnancyTerm.day.extend({ dateMustFill: true });
                    this.pregnancyTerm.month.extend({ dateMustFill: true });
                    this.pregnancyTerm.year.extend({ dateMustFill: true });
                    if (this.pregnancyTerm.day.isValid() && this.pregnancyTerm.month.isValid() && this.pregnancyTerm.year.isValid()) {
                        canSubmitFields = true;
                    } else {
                        canSubmitFields = false;
                    }
                    break;
            }
            return canSubmitFields;
        },
        init: function init(data) {
            data = (data === undefined) ? {} : data;
            this.id = ko.observable(data.id || null);
            this.type = Model.createStdProperty(data.type || null, 'type');
            this.relationshipStatus = Model.createStdProperty(data.relationshipStatus || null, 'relationshipStatus');
            this.gender = Model.createStdProperty(data.gender || null, 'gender');
            this.name = Model.createStdProperty(data.name || null, 'name');
            this.description = Model.createStdProperty(data.description || null, 'description');
            this.birthday = Model.createStdProperty(data.birthday || {}, 'birthday');
            this.birthday.day = ko.observable((data.birthday !== undefined) ? data.birthday.day : null);
            this.birthday.month = ko.observable((data.birthday !== undefined) ? data.birthday.month : null);
            this.birthday.year = ko.observable((data.birthday !== undefined) ? data.birthday.year : null);
            this.birthday.value = ko.computed(function () {
               return this.year() + '-' +  this.month() + '-' + this.day();
            }, this.birthday);
            this.ageString = Model.createStdProperty(data.ageString || null, 'ageString');
            this.pregnancyTerm = Model.createStdProperty(data.pregnancyTerm || {}, 'pregnancyTerm');
            this.pregnancyTerm.day = ko.observable((data.pregnancyTerm !== undefined) ? data.pregnancyTerm.day : null);
            this.pregnancyTerm.month = ko.observable((data.pregnancyTerm !== undefined) ? data.pregnancyTerm.month : null);
            this.pregnancyTerm.year = ko.observable((data.pregnancyTerm !== undefined) ? data.pregnancyTerm.year : null);
            this.pregnancyTerm.value = ko.computed(function () {
                return this.year() + '-' +  this.month() + '-' + this.day();
            }, this.pregnancyTerm);
            this.planningWhen = Model.createStdProperty(data.planningWhen || null, 'planningWhen');
            this.canSubmit = ko.computed(this.canSubmit, this);
            return this;
        }

    };
    return FamilyMember;
});