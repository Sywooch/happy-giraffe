function OnlineManager(user, channel) {
	var self = this;
	self.user = ko.observable(user);
	self.channel = channel;
	comet.addChannel(channel);

	self.addObject(self);
	self.bindEvent();
	console.log(this);
}

OnlineManager.prototype.objects = new Array();
OnlineManager.prototype.binded = false;

OnlineManager.prototype.addObject = function(obj) {
	this.objects.push(obj);
};

OnlineManager.prototype.bindEvent = function() {
	var self = this;
	if(!self.binded) {
		Comet.prototype.onlineManagerEvent = function(result, id) {
			console.log(result, id);
			ko.utils.arrayForEach(self.objects, function(obj) {
				if(obj.user().id == result.user.id) {
					obj.user(result.user);
				}
			});
		};
		comet.addEvent(3, 'onlineManagerEvent');
	}
};
