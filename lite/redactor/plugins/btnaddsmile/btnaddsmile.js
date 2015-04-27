if (!RedactorPlugins) var RedactorPlugins = {};
 
RedactorPlugins.btnaddsmile = function()
{
    return {
        init: function ()
        {
            var button = this.button.add('addsmile', 'Вставить смайл');
            this.button.addCallback(button, this.btnaddsmile.testButton);
        },
        testButton: function(buttonName)
        {
            alert(buttonName);
        }
    };
};