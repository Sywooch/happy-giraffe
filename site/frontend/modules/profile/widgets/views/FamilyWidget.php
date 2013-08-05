<div class="b-famyli">
    <div class="b-famyli_top b-famyli_top__white"></div>
    <ul class="b-famyli_ul">
        <li class="b-famyli_li">
            <div class="b-famyli_img-hold">
                <!-- Размеры изображений 55*55пк -->
                <img src="/images/example/w41-h49-1.jpg" alt="" class="b-famyli_img">
            </div>
            <div class="b-famyli_tx">
                <span>Жена</span> <br>
                <span>Елена</span>
            </div>
        </li>
        <?php foreach ($this->user->babies as $b): ?>
            <li class="b-famyli_li">
                <div class="b-famyli_img-hold">
                    <img src="/images/example/w60-h40.jpg" alt="" class="b-famyli_img">
                </div>
                <div class="b-famyli_tx">
                    <span>Сын</span> <br>
                    <span>Александр</span> <br>
                    <span>10 лет</span>
                </div>
            </li>
        <?php endforeach; ?>
        <li class="b-famyli_li">
            <div class="b-famyli_img-hold">
                <img src="/images/example/w64-h61-1.jpg" alt="" class="b-famyli_img">
            </div>
            <div class="b-famyli_tx">
                <span>Дочь</span> <br>
                <span>Снежана</span> <br>
                <span>2,5 года</span>
            </div>
        </li>
        <li class="b-famyli_li">
            <div class="b-famyli_img-hold">
                <div class="ico-child ico-child__girl-small"></div>
            </div>
            <div class="b-famyli_tx">
                <span>Дочь</span> <br>
                <span>Снежана</span> <br>
                <span>2,5 года</span>
            </div>
        </li>
        <li class="b-famyli_li">
            <div class="b-famyli_img-hold">
                <div class="ico-child ico-child__boy-small"></div>
            </div>
            <div class="b-famyli_tx">
                <span>Дочь</span> <br>
                <span>Снежана</span> <br>
                <span>2,5 года</span>
            </div>
        </li>
        <li class="b-famyli_li">
            <div class="b-famyli_img-hold">
                <a href="" class="b-famyli_more">еще 3</a>
            </div>
            <div class="b-famyli_tx">
            </div>
        </li>
    </ul>
</div>