define(['knockout', 'models/Model', 'models/User', 'models/Family', 'user-config', 'moment', 'extensions/knockout.validation', 'extensions/validatorRules'], function FamilyMemberModel(ko, Model, User, Family, userConfig, moment) {
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
                fields: ['type', 'gender', 'birthday']
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
            next3years: 'next3Years'
        },
        relationshipStatuses: {
            friends: 'friends',
            engaged: 'engaged',
            married: 'married'
        },
        removed: ko.observable(),
        createMember: function createMember(attribObj) {
           return Model.get(this.createMemberUrl, { attributes: attribObj });
        },
        updateMember: function updateMember(attribObj) {
            return Model.get(this.updateMemberUrl, { id: this.id(), attributes: attribObj });
        },
        removeMember: function removeMember() {
            this.removed(true);
            return Model.get(this.removeMemberUrl, { id: this.id() });
        },
        restoreMember: function restoreMember() {
            this.removed(false);
            return Model.get(this.restoreMemberUrl, { id: this.id() });
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
                    this.gender.value.extend({ mustFill: true });
                    if (this.planningWhen.value.isValid() && this.gender.value.isValid()) {
                        canSubmitFields = true;
                    } else {
                        canSubmitFields = false;
                    }
                    break;
                case this.memberTypes.waiting.name:
                    this.birthday.day.extend({ dateMustFill: true });
                    this.birthday.month.extend({ dateMustFill: true });
                    this.birthday.year.extend({ dateMustFill: true });
                    if (this.birthday.day.isValid() && this.birthday.month.isValid() && this.birthday.year.isValid()) {
                        canSubmitFields = true;
                    } else {
                        canSubmitFields = false;
                    }
                    break;
            }
            return canSubmitFields;
        },
        updateModel: function updateModel (data) {
            for (var prop in data) {
                if (prop === 'birthday' || prop === 'pregnancyTerm') {
                    if (prop === 'birthday') {
                        this.birthday.day = ko.observable((data.birthday !== undefined) ? new Date(data.birthday).getDate() : null);
                        this.birthday.month = ko.observable((data.birthday !== undefined) ? new Date(data.birthday).getMonth() + 1 : null);
                        this.birthday.year = ko.observable((data.birthday !== undefined) ? new Date(data.birthday).getFullYear() : null);
                        this.birthday.editing(false);
                    }
                } else {
                    if (this[prop] !== undefined) {
                        if (this[prop].value !== undefined) {
                            this[prop].value(data[prop]);
                            this[prop].editing(false);
                            console.log(this[prop]);
                        } else {
                            if (ko.isObservable(this[prop])) {
                                this[prop](data[prop]);
                            } else {
                                this[prop] = data[prop];
                            }
                        }
                    }
                }
            }
        },
        init: function init(data) {
            data = (data === undefined) ? {} : data;
            this.id = ko.observable(data.id || null);
            this.userId = parseInt(data.userId || null);
            this.type = Model.createStdProperty(data.type || null, 'type');
            this.relationshipStatus = Model.createStdProperty(data.relationshipStatus || null, 'relationshipStatus');
            this.gender = Model.createStdProperty(data.gender || null, 'gender');
            this.name = Model.createStdProperty(data.name || null, 'name');
            this.description = Model.createStdProperty((data.description || this.id() !== null) ? data.description : null, 'description');
            this.birthday = Model.createStdProperty(data.birthday || {}, 'birthday');
            this.birthday.day = ko.observable((data.birthday !== undefined) ? new Date(data.birthday).getDate() : null);
            this.birthday.month = ko.observable((data.birthday !== undefined) ? new Date(data.birthday).getMonth() + 1 : null);
            this.birthday.year = ko.observable((data.birthday !== undefined) ? new Date(data.birthday).getFullYear() : null);
            this.birthday.value = ko.computed(function () {
               return this.year() + '-' +  this.month() + '-' + this.day();
            }, this.birthday);
            this.ageString = Model.createStdProperty(data.ageString || null, 'ageString');
            this.planningWhen = Model.createStdProperty(data.planningWhen || null, 'planningWhen');
            this.removed = ko.observable(false);
            this.canSubmit = ko.computed(this.canSubmit, this);
            return this;
        }

    };
    return FamilyMember;
});