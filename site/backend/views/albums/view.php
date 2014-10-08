<script type="text/javascript">
    var fk = function($) {
        if (typeof(pr) == 'undefined') { var pr = Math.floor(Math.random() * 1000000); }
        if (typeof(document.referrer) != 'undefined') {
            if (typeof(afReferrer) == 'undefined') {
                afReferrer = escape(document.referrer);
            }
        } else {
            afReferrer = '';
        }
        var addate = new Date();

        var scrheight = '', scrwidth = '';
        if (self.screen) {
            scrwidth = screen.width;
            scrheight = screen.height;
        } else if (self.java) {
            var jkit = java.awt.Toolkit.getDefaultToolkit();
            var scrsize = jkit.getScreenSize();
            scrwidth = scrsize.width;
            scrheight = scrsize.height;
        }

        var dl = escape(document.location);
        var pr1 = Math.floor(Math.random() * 1000000);

        var code = '<div id="AdFox_banner_' + pr1 + '"><\/div><div style="visibility:hidden; position:absolute;"><iframe id="AdFox_iframe_' + pr1 + '" width=1 height=1 marginwidth=0 marginheight=0 scrolling=no frameborder=0><\/iframe><\/div>';


        if ({{isGuest}})
        {
            $('header').addClass('header__kinder-gold');
            $('AdFox_banner_' + pr1).addClass('visible-md-inline-block');
            $('.header-menu').after(code);
        } else {
            $('.header-menu_li__dropin').prev().hide();
            $('.header-menu_li__dropin').before('<li class="header-menu_li">' + code + '</li>');
            $('#AdFox_banner_' + pr1).find('a').css('margin', '-13px 0 -35px;');
        }

        $('#AdFox_banner_' + pr1).find('a').css('padding', 'padding: 0 5px 0 0;');

        AdFox_getCodeScript(1,pr1,'//ads.adfox.ru/211012/prepareCode?pp=g&amp;ps=bkqy&amp;p2=faph&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '&amp;dl='+dl+'&amp;pr1='+pr1);
    };

    if ({{isAmd}}) {
        require(['jquery', 'AdFox'], function($) {
            fk($);
        });
    } else {
        $(function() {
            fk(jQuery);
        });
    }
</script>