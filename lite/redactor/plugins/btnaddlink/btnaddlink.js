if (!RedactorPlugins) var RedactorPlugins = {};
 
RedactorPlugins.btnaddlink = function()
{
    return {
        init: function ()
        {
            var button = this.button.add('addlink', 'Вставить ссылку');
            this.button.addCallback(button, this.btnaddlink.testButton);
        },
        testButton: function(buttonName)
        {
            alert(buttonName);
        }
    };
};