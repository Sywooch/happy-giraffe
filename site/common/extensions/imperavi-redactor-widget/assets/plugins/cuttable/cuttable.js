if (!RedactorPlugins) var RedactorPlugins = {};

RedactorPlugins.cuttable = {

    init: function()
    {
        this.buttonAdd('cuttable', 'Cuttable', function()
        {
            this.insertHtml('<hr class="cuttable" />');
        });
    }

}

