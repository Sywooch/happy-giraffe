define(['ads-config', 'extensions/history'], function (adsConfig) {
	var AdHistory = {
        pushState: function (first, title, currentUrl) {
					  history.pushState(first, title, currentUrl);
						//Яндекс счетчик, переменная пока глобальная и захардкожена
            this.addViews(currentUrl);
				},
        addViews: function addViews(currentUrl) {
            if (adsConfig.isProduction === true) {
                $.post('/api/analytics/processHit/', JSON.stringify({ inc: true, url: currentUrl }));
                yaCounter11221648.hit(currentUrl);
                dataLayer.push({'event': 'virtualView'});
            }
        },
        reloadBanner: function reloadBanner() {
            if (adsConfig.showAds === true) {
                adfox_reloadBanner('bn-1');
            }
        },
        bannerInit: function bannerInit(currentUrl) {
            if (adsConfig.showAds === true) {
                (function (bannerPlaceId, requestSrc, defaultLoad) {
                    var
                        tgNS = window.ADFOX.RELOAD_CODE,
                        initData = tgNS.initBanner(bannerPlaceId, requestSrc);

                    $('#photo-window_banner .display-ib').html(initData.html);

                    if (defaultLoad) {
                        tgNS.loadBanner(initData.pr1, requestSrc, initData.sessionId);
                    }
                })('bn-1', 'http://ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a', true);
                this.addViews(currentUrl);
            }
        }
	};
	return AdHistory;
});
