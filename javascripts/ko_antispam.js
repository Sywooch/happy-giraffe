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
                parent.check(response.check);
        }, 'json');
    }

    self.isMarked = ko.computed(function() {
        return ! $.inArray(self.status, [parent.statuses.UNDEFINED, parent.statuses.QUESTIONABLE]);
    });
}

function Moderator(data)
{
    var self = this;

    self.id = data.id;
    self.ava = data.ava;
    self.online = data.online;
}