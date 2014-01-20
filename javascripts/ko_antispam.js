function markGoodAll(entity, userId)
{
    $.post('/antispam/check/markGoodAll/', { entity : entity, userId : userId }, function(response) {
        if (response.success)
            document.location.reload();
    }, 'json');
}

function MarkWidget(data)
{
    var self = this;

    self.statuses = data.statuses;
    self.check = ko.observable(new AntispamCheck(data.check, self));
}

function AntispamCheck(data, parent)
{
    var self = this;

    self.id = data.id;
    self.status = ko.observable(data.status);
    self.updated = ko.observable(data.updated);
    self.moderator = ko.observable(data.moderator === null ? null : new Moderator(data.moderator));

    self.mark = function(newStatus) {
        $.post('/antispam/check/mark/', { checkId : self.id, status : newStatus }, function(response) {
            if (response.success)
                parent.check(new AntispamCheck(response.check, parent));
        }, 'json');
    }

    self.isMarked = ko.computed(function() {
        return self.status() != parent.statuses.UNDEFINED;
    });

    self.iconClass = ko.computed(function() {
        var cssClass;
        switch (self.status()) {
            case parent.statuses.GOOD:
                cssClass = 'check';
                break;
            case parent.statuses.BAD:
                cssClass = 'del';
                break;
            case parent.statuses.QUESTIONABLE:
                cssClass = 'question';
                break;
        }
        return 'ico-' + cssClass;
    });
}

function UserMarkWidget(data)
{
    var self = this;

    self.statuses = data.statuses;
    self.user_id = data.user_id;
    self.status = ko.observable(data.status === null ? null : new AntispamStatus(data.status, self));

    self.handle = function(newStatus) {
        if (self.status() == newStatus)
            self.mark(self.statuses.GRAY);
        else
            self.mark(newStatus);
    }

    self.mark = function(newStatus) {
        $.post('/antispam/userStatus/listUser/', { userId : self.user_id, status : newStatus }, function(response) {
            if (response.success)
                self.status(new AntispamStatus(response.status, parent));
        }, 'json');
    }
}

function AntispamStatus(data, parent)
{
    var self = this;

    self.id = data.id;
    self.user_id = data.user_id;
    self.status = ko.observable(data.status);
    self.updated = ko.observable(data.updated);
    self.moderator = ko.observable(data.moderator === null ? null : new Moderator(data.moderator));
}

function Moderator(data)
{
    var self = this;

    self.id = data.id;
    self.ava = data.ava;
    self.online = data.online;
    self.fullName = data.fullName;
    self.url = data.url;

    self.iconClass = function() {
        return self.online() ? ' ico-status__online' : ' ico-status__offline';
    }
}