var Messages = {

}

Messages.updateStatus = function(online, user_id)
{
    alert('Юзер ' + user_id + ' поменял статус на ' + online);
}

Comet.prototype.updateStatus = function (result, id) {
    Messages.updateStatus(result.online, result.user_id);
}
comet.addEvent(3, 'updateStatus');