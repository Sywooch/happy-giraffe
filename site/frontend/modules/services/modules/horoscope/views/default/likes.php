<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <script src="http://vkontakte.ru/js/api/openapi.js" type="text/javascript"></script>
    <script src="http://stg.odnoklassniki.ru/share/odkl_share.js" type="text/javascript"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        function openPopup(el) {
            window.open($(el).attr('href'), '', 'height=350,width=500');
            return false;
        }
    </script>
    <style type="text/css">
        .custom-likes-small {text-align: center;}
        .custom-like-small {display: inline-block;*zoom:1;*display:inline;margin: 0 1px 0 2px;text-decoration: none; }
        .custom-like-small_icon {width: 24px;height: 24px;float: left;background: url(/images/custom-like-small.png) no-repeat;}
        .custom-like-small_icon.odnoklassniki {background-position: 0 0;}
        .custom-like-small_icon.mailru {background-position: 0 -24px;}
        .custom-like-small_icon.vk {background-position: 0 -48px;}
        .custom-like-small_icon.fb {background-position: 0 -72px;}
        .custom-like-small_value{float:left;background:#fff;border:1px solid #d2d2d2;padding:0 4px;height:22px;font:11px/22px Arial,Tahoma,Verdana,sans-serif;margin:0 0 0 5px;position:relative;color:#000;}
        .custom-like-small:hover .custom-like-small_value{text-decoration:underline;color:#000;}
        .custom-like-small_value:before,
        .custom-like-small_value:after{content:"";position:absolute;margin:-4px 0 0 -4px;line-height:0;width:0;height:0;left:0;top:50%;border:4px transparent solid;border-left:0;border-right-color:#d5d5d5;}
        .custom-like-small_value:after {margin-left:-3px;border-right-color: white;}
    </style>
</head>
<body onload="ODKL.init();">
    <?php $url = 'http://www.happy-giraffe.ru/horoscope/aries/'; ?>
    <div class="custom-likes-small">
        <a class="custom-like-small" href="<?= $url?>" onclick="ODKL.Share(this);return false;">
            <span class="custom-like-small_icon odkl"></span>
            <span class="custom-like-small_value custom-like-small_icon odkl" id="likes-count-ok">0</span>
        </a>

        <a class="custom-like-small" href="http://vkontakte.ru/share.php?url=<?= $url?>"
           target="_blank" onclick="return openPopup(this)">
            <span class="custom-like-small_icon vk"></span>
            <span class="custom-like-small_value" id="likes-count-vk">0</span>
        </a>

        <a class="custom-like-small" href="http://www.facebook.com/sharer/sharer.php?u=<?= urlencode($url)?>"
           target="_blank" onclick="return openPopup(this);">
            <span class="custom-like-small_icon fb"></span>
            <span class="custom-like-small_value" id="likes-count-fb">0</span>
        </a>
    </div>
    <script type="text/javascript">
        $.getJSON("http://graph.facebook.com", { id:"<?=$url ?>" }, function (json) {
            $('#likes-count-fb').html(json.shares || '0');
        });

        VK = {};
        VK.Share = {};
        VK.Share.count = function(index, count){
            $('#likes-count-vk').text(count);
        };
        $.getJSON('http://vkontakte.ru/share.php?act=count&index=1&url=<?= urlencode($url)?>&format=json&callback=?');

        ODKL.updateCountOC = function(index, count){
            $('#likes-count-ok').text(count);
        };

        var ok_url = 'http://www.odnoklassniki.ru/dk?st.cmd=extOneClickLike&uid=odklock0&ref=<?= urlencode($url)?>';
        //$.getJSON(ok_url);
        $.support.cors = true;
        $.ajax({
            url:ok_url,
            dataType: 'jsonp', // Notice! JSONP <-- P (lowercase)
            success:function(json){
                // do stuff with json (in this case an array)
                alert("Success");
            },
            error:function(){
                alert("Error");
            },
        });
    </script>

</body>

</html>