/*!
 * jQuery Countdown plugin v1.0
 * http://www.littlewebthings.com/projects/countdown/
 *
 * Copyright 2010, Vassilis Dourdounis
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
(function($){

	$.fn.countDown = function (options) {

		config = {};

		$.extend(config, options);
		numberSet = this.setCountDown(config);
		
		var $this = $(this);
		console.log($this);
		if (config.onComplete)
		{
			$.data($this[0], 'callback', config.onComplete);
		}

		$(this).find('.counter-users_digit').html('<div class="top"></div><div class="bottom"></div>');
		$(this).doCountDown($(this).attr('id'), numberSet, 500);

		return this;

	};

	$.fn.stopCountDown = function () {
		clearTimeout($.data(this[0], 'timer'));
	};

	$.fn.startCountDown = function () {
		this.doCountDown($(this).attr('id'),$.data(this[0], 'numberSet'), 500);
	};

	$.fn.setCountDown = function (options) {

		var numberSet = options.numberSet;
		$.data(this[0], 'numberSet', numberSet);

		return numberSet;
	};

	$.fn.doCountDown = function (id, numberSet, duration) {
		$this = $('#' + id);

		$this.dashChangeTo(id, 'counter-users_dash', numberSet, duration ? duration : 500);
		$.data($this[0], 'numberSet', numberSet);
		if (numberSet > 0)
		{
			e = $this;
			numberSet++;
			t = setTimeout(function() { e.doCountDown(id, numberSet) } , 1000);
			$.data(e[0], 'timer', t);
		} 
		else if (cb = $.data($this[0], 'callback')) 
		{
			$.data($this[0], 'callback')();
		}

	};

	$.fn.dashChangeTo = function(id, dash, n, duration) {
		  $this = $('#' + id);
		 
		  for (var i=($this.find('.counter-users_digit').length-1); i>=0; i--)
		  {
				var d = n%10;
				n = (n - d) / 10;
				$this.digitChangeTo($(this).find('.counter-users_digit:eq('+i+')'), d, duration);
		  }
	};

	$.fn.digitChangeTo = function (digit, n, duration) {
		if (!duration)
		{
			duration = 800;
		}
		digit.top = digit.find('.top');
		digit.bottom = digit.find('.bottom');
		if (digit.top.html() != n + '')
		{

			digit.top.css({'display': 'none'});
			digit.top.html((n ? n : '0')).slideDown(duration);

			digit.bottom.animate({'height': ''}, duration, function() {
				digit.bottom.html($(digit + ' div.top').html());
				digit.bottom.css({'display': 'block', 'height': ''});
				digit.bottom.hide().slideUp(10);

			
			});
		}
	};

})(jQuery);


