<!DOCTYPE html>
<html>
  <head>
	<script type="text/javascript">
		<?php
            $code = "
                //document.domain = document.location.host;

                var inc = " . CJSON::encode($inc) . ";
                window.location = '" . addslashes($url) . "';
                if (inc) {
                    var parentEl = window.opener.$('#blog_settings_" . $pk . "');
                    var el = parentEl.find('.contest-counter');
                    el.text(parseInt(el.first().text()) + 1);
                    parentEl.find('.contest-meter_vote').removeClass('display-b');

                    var service = " . CJSON::encode($service) . ";
                    var counter;
                    switch (service) {
                        case 'facebook':
                            counter = parentEl.find('.custom-like-fb-share-count');
                            break;
                        case 'vkontakte':
                            counter = parentEl.find('.custom-like-vk_value');
                            break;
                        case 'odnoklassniki':
                            counter = parentEl.find('.custom-like-odkl_value');
                            break;
                        case 'twitter':
                            counter = parentEl.find('.custom-like-tw_value');
                            break;
                    }

                    console.log(counter);
                    counter.text(parseInt(counter.first().text()) + 1);
                }

            ";
			echo $code;
		?>
	</script>
  </head>
  <body>
	<h2 id="title" style="display:none;">Redirecting back to the application...</h2>
	<h3 id="link"><a href="<?php echo $url; ?>">Click here to return to the application.</a></h3>
	<script type="text/javascript">
		document.getElementById('title').style.display = '';
		document.getElementById('link').style.display = 'none';
	</script>
  </body>
</html>