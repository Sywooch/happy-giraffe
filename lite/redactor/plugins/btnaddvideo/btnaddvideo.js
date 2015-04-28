if (!RedactorPlugins) var RedactorPlugins = {};
 
RedactorPlugins.btnaddvideo = function()
{
    return {
        init: function ()
        {
            var button = this.button.add('addvideo', 'Добавить видео');
            this.button.addCallback(button, this.btnaddvideo.testButton);
        },
        testButton: function(buttonName)
        {
            alert(buttonName);
        }
    };
};