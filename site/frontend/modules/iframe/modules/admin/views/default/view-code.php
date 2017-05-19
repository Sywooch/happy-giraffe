<?php $text = "
<div id='iframe-pediatr'></div>
<script>
    (function (d, s, u, e, i) {e = d.createElement(s);e.src = u;e.onload = function () {
            iPediatr.createIframe('ipediatr', 'http://www.ds1.brown.hgdev.code-geek.ru/','".$model->key."');
    };d.getElementsByTagName('head')[0].appendChild(e);
    })(document, 'script', 'http://www.ds1.brown.hgdev.code-geek.ru/for-iframe/js/iframe-pediatr.js');
</script>"; ?>
<pre>
    <?php echo htmlspecialchars($text, ENT_QUOTES);?>
</pre>
