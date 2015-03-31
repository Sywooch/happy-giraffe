if (!RedactorPlugins) var RedactorPlugins = {};
 
RedactorPlugins.btnaddphoto = function()
{
    return {
        init: function ()
        {
            var button = this.button.add('addphoto', 'Добавить фото');
            this.button.addCallback(button, this.btnaddphoto.testButton);
        },
        testButton: function(buttonName)
        {
            alert(buttonName);
        }
    };
};