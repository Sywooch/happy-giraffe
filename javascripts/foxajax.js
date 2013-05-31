(function(){
    /*
     AdFox AJAX banners lib;
     Created for SGMGBUREAU.RU 10.09.2012;
     Modified: beta_AJAX_Embeds;
     */
    window.ADFOX = (window.ADFOX) || {};
    window.ADFOX.getNSReference = (window.ADFOX.getNSReference) || function(referenceString, value)
    {
        var referenceArray = referenceString.split('.'),
            currentElement = window.ADFOX;
        if (referenceArray[0] === "ADFOX") {
            referenceArray = referenceArray.slice(1);
        }
        for (var i = 0, len = referenceArray.length; i < len; i += 1) {
            if (typeof currentElement[referenceArray[i]] === "undefined") {
                currentElement[referenceArray[i]] = {};
            }
            currentElement = currentElement[referenceArray[i]];
        }
        return currentElement;
    };

    var AJAX_NS = window.ADFOX.getNSReference('ADFOX.AJAX_EMBEDS'); //var AJAX_NS = AJAX_EMBEDS
    AJAX_NS.requests = [];
    AJAX_NS.clean = [];
    AJAX_NS.parameters = {};

    function adfoxAJAXEmbed(staticParametersString, placeholderId, reload)
    {
        if(reload)
        {
            AJAX_NS.requests.push([staticParametersString, placeholderId]);
        }

        var adfoxPageReferrer,
            adfoxRandom,
            adfoxScreenWidth,
            adfoxScreenHeight,
            adfoxLocation = escape(document.location),
            adfoxDate = new Date(),
            placeholder = document.getElementById(placeholderId),
            oldScript,
            requestString,
            scriptId = 'loader_'+placeholderId,
            script;

        if(placeholder)
        {
            adfoxPageReferrer = AJAX_NS.parameters.referrer = (typeof(document.referrer) != 'undefined')?((AJAX_NS.parameters.referrer)?(AJAX_NS.parameters.referrer):(escape(document.referrer))):'';

            adfoxRandom = AJAX_NS.parameters.random = (AJAX_NS.parameters.random)?(AJAX_NS.parameters.random):(Math.floor(Math.random() * 1000000));

            if (window.screen)
            {
                adfoxScreenWidth = screen.width;
                adfoxScreenHeight = screen.height;
            }
            else if (window.java)
            {
                var jkit = java.awt.Toolkit.getDefaultToolkit();
                var scrsize = jkit.getScreenSize();
                adfoxScreenWidth = scrsize.width;
                adfoxScreenHeight = scrsize.height;
            }

            requestString = staticParametersString + '&pr='+adfoxRandom+'&prr='+adfoxPageReferrer+'&pd='+adfoxDate.getDate()+
                '&pw='+adfoxDate.getDay()+'&pv='+adfoxDate.getHours()+'&pdw'+adfoxScreenWidth+'&pdh='+adfoxScreenHeight+
                '&dl='+adfoxLocation+'&phid='+placeholderId;

            oldScript = document.getElementById(scriptId);
            if(oldScript)
            {
                oldScript.parentNode.removeChild(oldScript);
            }

            script = document.createElement('SCRIPT');
            script.type = 'text/javascript';
            script.src = requestString;
            script.id = scriptId;
            placeholder.parentNode.insertBefore(script, placeholder);
        }
    }

    AJAX_NS.adfoxAJAXEmbed = adfoxAJAXEmbed; //Embed function;

    function reloadBanners()
    {
        var AJAX_NS = window.ADFOX.getNSReference('ADFOX.AJAX_EMBEDS');
        for(var i=0, len = AJAX_NS.clean.length; i < len; i++)
        {
            if(typeof AJAX_NS.clean[i] == 'function')
            {
                AJAX_NS.clean[i]();
            }
        }
        AJAX_NS.clean = [];
        AJAX_NS.parameters = {};
        for(var i=0, len = AJAX_NS.requests.length; i < len; i++)
        {
            AJAX_NS.adfoxAJAXEmbed(AJAX_NS.requests[i][0], AJAX_NS.requests[i][1], false);
        }
    }

    AJAX_NS.reloadBanners = reloadBanners;

})();