<?php
$categories = CookDecorationCategory::model()->findAll();
?>


<div id="crumbs"><a href="">Главная</a> > <a href="">Сервисы</a> > <span>Приправы и специи</span></div>

<div id="dishes">

<div class="title">

    <h2>Оформление <span>блюд</span></h2>

</div>

<div class="dishes-cats clearfix">

    <ul>
        <li>
            <span class="valign"></span>
            <a href="" class="cook-cat">
                <i class="icon-cook-cat icon-dish-0"></i>
                <span>Все</span>
            </a>
        </li>
        <?php
        foreach ($categories as $category) {
            ?>
            <li>
                <span class="valign"></span>
                <a href="" class="cook-cat">
                    <i class="icon-cook-cat icon-dish-<?=$category->id;?>"></i>
                    <span><?=$category->title;?></span>
                </a>
            </li>
            <?php
        }
        ?>

    </ul>

</div>

<div class="dishes-list">

<div class="block-title">

    <div class="add-photo">
        Нашли интересное оформление или<br/>хотите похвастаться своим творением<br/>
        <a href="#photoPick" class="btn btn-green fancy"><span><span>Добавить фото</span></span></a>
        <?php
        $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
            'model' => new CookDecoration(),
        ));
        $fileAttach->button();
        $this->endWidget();
        ?>
    </div>

    <h1>Как можно оформить десерты и выпечку</h1>

</div>

<ul>
    <li>
        <div class="clearfix">
            <div class="user-info clearfix">
                <a class="ava female small"></a>

                <div class="details">
                    <span class="icon-status status-online"></span>
                    <a href="" class="username">Александр Богоявленский</a>
                </div>
            </div>
        </div>
        <div class="img">
            <a href=""><img src="/images/dishes_img_02.jpg"/></a>
            <a href="" class="btn-look">Посмотреть</a>
        </div>
        <div class="item-title">
            Ригатони
        </div>
    </li>
    <li>
        <div class="clearfix">
            <div class="user-info clearfix">
                <a class="ava female small"></a>

                <div class="details">
                    <span class="icon-status status-online"></span>
                    <a href="" class="username">Дарья</a>
                </div>
            </div>
        </div>
        <div class="img">
            <a href=""><img src="/images/dishes_img_01.jpg"/></a>
            <a href="" class="btn-look">Посмотреть</a>
        </div>
        <div class="item-title">
            Ригатони - макароны с соусомиз помидор и говядинв
        </div>
    </li>
    <li>
        <div class="clearfix">
            <div class="user-info clearfix">
                <a class="ava female small"></a>

                <div class="details">
                    <span class="icon-status status-online"></span>
                    <a href="" class="username">Дарья</a>
                </div>
            </div>
        </div>
        <div class="img">
            <a href=""><img src="/images/dishes_img_01.jpg"/></a>
            <a href="" class="btn-look">Посмотреть</a>
        </div>
        <div class="item-title">
            Ригатони - макароны с соусомиз помидор и говядинв
        </div>
    </li>
    <li>
        <div class="clearfix">
            <div class="user-info clearfix">
                <a class="ava female small"></a>

                <div class="details">
                    <span class="icon-status status-online"></span>
                    <a href="" class="username">Дарья</a>
                </div>
            </div>
        </div>
        <div class="img">
            <a href=""><img src="/images/dishes_img_02.jpg"/></a>
            <a href="" class="btn-look">Посмотреть</a>
        </div>
        <div class="item-title">
            Ригатони - макароны с соусомиз помидор и говядинв
        </div>
    </li>
    <li>
        <div class="clearfix">
            <div class="user-info clearfix">
                <a class="ava female small"></a>

                <div class="details">
                    <span class="icon-status status-online"></span>
                    <a href="" class="username">Дарья</a>
                </div>
            </div>
        </div>
        <div class="img">
            <a href=""><img src="/images/dishes_img_01.jpg"/></a>
            <a href="" class="btn-look">Посмотреть</a>
        </div>
        <div class="item-title">
            Ригатони - макароны с соусомиз помидор и говядинв
        </div>
    </li>
    <li>
        <div class="clearfix">
            <div class="user-info clearfix">
                <a class="ava female small"></a>

                <div class="details">
                    <span class="icon-status status-online"></span>
                    <a href="" class="username">Дарья</a>
                </div>
            </div>
        </div>
        <div class="img">
            <a href=""><img src="/images/dishes_img_02.jpg"/></a>
            <a href="" class="btn-look">Посмотреть</a>
        </div>
        <div class="item-title">
            Ригатони - макароны с соусомиз помидор и говядинв
        </div>
    </li>
    <li>
        <div class="clearfix">
            <div class="user-info clearfix">
                <a class="ava female small"></a>

                <div class="details">
                    <span class="icon-status status-online"></span>
                    <a href="" class="username">Дарья</a>
                </div>
            </div>
        </div>
        <div class="img">
            <a href=""><img src="/images/dishes_img_01.jpg"/></a>
            <a href="" class="btn-look">Посмотреть</a>
        </div>
        <div class="item-title">
            Ригатони - макароны с соусомиз помидор и говядинв
        </div>
    </li>
    <li>
        <div class="clearfix">
            <div class="user-info clearfix">
                <a class="ava female small"></a>

                <div class="details">
                    <span class="icon-status status-online"></span>
                    <a href="" class="username">Дарья</a>
                </div>
            </div>
        </div>
        <div class="img">
            <a href=""><img src="/images/dishes_img_01.jpg"/></a>
            <a href="" class="btn-look">Посмотреть</a>
        </div>
        <div class="item-title">
            Ригатони - макароны с соусомиз помидор и говядинв
        </div>
    </li>
    <li>
        <div class="clearfix">
            <div class="user-info clearfix">
                <a class="ava female small"></a>

                <div class="details">
                    <span class="icon-status status-online"></span>
                    <a href="" class="username">Дарья</a>
                </div>
            </div>
        </div>
        <div class="img">
            <a href=""><img src="/images/dishes_img_01.jpg"/></a>
            <a href="" class="btn-look">Посмотреть</a>
        </div>
        <div class="item-title">
            Ригатони - макароны с соусомиз помидор и говядинв
        </div>
    </li>
    <li>
        <div class="clearfix">
            <div class="user-info clearfix">
                <a class="ava female small"></a>

                <div class="details">
                    <span class="icon-status status-online"></span>
                    <a href="" class="username">Дарья</a>
                </div>
            </div>
        </div>
        <div class="img">
            <a href=""><img src="/images/dishes_img_01.jpg"/></a>
            <a href="" class="btn-look">Посмотреть</a>
        </div>
        <div class="item-title">
            Ригатони - макароны с соусомиз помидор и говядинв
        </div>
    </li>


</ul>

</div>

</div>
