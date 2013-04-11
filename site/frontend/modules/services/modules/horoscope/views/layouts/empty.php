<html>
<head>
    <meta name="robots" content="noindex,nofollow">
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <script type="text/javascript">
        function openPopup(el) {window.open($(el).attr('href'),'','toolbar=0,status=0,width=626,height=436');return false;}
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
        html, body{min-width:0 !important;background: none !important;}
    </style>
</head>
<body>
<?=$content ?>
</body>
</html>