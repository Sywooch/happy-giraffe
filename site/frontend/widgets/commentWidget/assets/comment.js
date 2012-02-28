var Comment = {
    response : function() {
        
    },
    goTo : function() {
        var h = new AjaxHistory('yw0');
        var url = 'http://happyfront/community/2/forum/post/447/?Comment_page=3';
        h.load('yw0', url).changeBrowserUrl(url);
    }
}