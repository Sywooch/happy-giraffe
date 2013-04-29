function FriendsSearchViewModel() {
    self.query = ko.observable('');

    self.clearQuery = function() {
        self.query('');
    }
}