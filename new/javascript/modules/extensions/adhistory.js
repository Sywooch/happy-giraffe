define(['extensions/history'], function () {
	var AdHistory = {
		pushState: function (first, title, currentUrl) {
			history.pushState(first, title, currentUrl);
			//Яндекс счетчик, переменная пока глобальная и захардкожена
			if (typeof yaCounter11221648 !== 'undefined') {
				yaCounter11221648.hit(currentUrl)
			}
			//Google tag, переменная пока глобальная и захардкожена
			if (typeof dataLayer !== 'undefined') {
				dataLayer.push({'event': 'virtualView'})
			}
		}
	};
	return AdHistory;
});