<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title><?=$this->pageTitle?></title>
    <meta name="viewport" content="width = device-width">
    <!-- <link rel='shortcut icon' href='favicon.ico'>-->
    <link href="/lite/css/dev/all.css" media="all" rel="stylesheet">
</head>
<body class="new-forum">
<div class="page-wrapper">
    <header class="header header__redesign"><a class="mobile-menu"></a><a href="/" class="logo"></a>
        <ul class="top-menu">
            <li><a href="#"><img src="/images/icons/forums.png">ФОРУМЫ</a></li>
            <li><a href="#"><img src="/images/icons/answers.png">ОТВЕТЫ</a></li>
            <li><a href="#"><img src="/images/icons/blogs.png">БЛОГИ</a></li>
            <li><a href="#"><img src="/images/icons/life.png">ЖИЗНЬ</a></li>
        </ul>
        <div style="display:none;" class="login"><a href="#"><img src="/images/icons/avatar.png">ВОЙТИ</a></div>
        <div class="user-on"><a href="#" class="signal active"></a>
            <div class="ava"><a href="#"><img src="/images/icons/ava.jpg"></a></div>
        </div>
    </header>
    <div class="b-main">
        <?=$content?>
    </div>
    <footer class="footer"></footer>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
<script src="/lite/javascript/common.js"></script>
</body>
</html>