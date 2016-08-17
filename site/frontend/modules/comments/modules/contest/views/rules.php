<?php
$this->pageTitle = $this->contest->name . ' - Правила';
?>

<div class="contest-commentator-how">
    <div class="contest-commentator-how_hold">
        <h2 class="contest-commentator_t">Как стать лидером</h2>
        <div class="contest-commentator-how_i contest-commentator-how_i__1">
            <div class="contest-commentator-how_tx">Находи различные записи в клубах и блогах, комментируй их. А так же вступай в дискуссии с другими пользователями - отвечай на их комментарии.</div>
        </div>
        <div class="contest-commentator-how_i contest-commentator-how_i__2">
            <div class="contest-commentator-how_tx">Пиши интересные и полезные комментарии, чтобы они нравились другим пользователям и призывали к дальнейшему обсуждению записей.</div>
        </div>
        <div class="contest-commentator-how_i contest-commentator-how_i__3">
            <div class="contest-commentator-how_tx">Много комментариев и живое общение - вот твой ключ к успеху!</div>
        </div>
    </div>
</div>
<div class="contest-commentator-example">
    <h2 class="contest-commentator_t">Пример комментария</h2>
    <div class="contest-commentator-example_in">
        <div class="comments comments__buble">
            <div class="comments_hold">
                <ul class="comments_ul">
                    <!--
                    варианты цветов комментов. В такой последовательности
                    .comments_li__lilac
                    .comments_li__yellow
                    .comments_li__red
                    .comments_li__blue
                    .comments_li__green
                    -->
                    <li class="comments_li comments_li__blue">
                        <div class="comments_i clearfix">
                            <div class="comments_ava">
                                <!-- ava--><a href="http://www.happy-giraffe.ru/user/264378/" class="ava"><img alt="" src="http://img.happy-giraffe.ru/v2/crops/avatarMedium/dd/a7/1878659de374ee67273e67b83cb8.jpg" class="ava_img"></a>
                            </div>
                            <div class="comments_frame">
                                <div class="comments_header"><a href="http://www.happy-giraffe.ru/user/264378/" rel="author" class="a-light comments_author">Кристина Ткаченко</a>
                                    <time datetime="2012-12-23" class="tx-date">2 минуты назад</time>
                                </div>
                                <div class="comments_cont">
                                    <div class="wysiwyg-content">
                                        <p>Ну ты прям прелесть. Такой кругленький пупсик))) Осталось и в правду совсем малость. Как все ж быстро летят недельки)) А чего мужчинкам своим дарила? Как в целом себя чувствуешь? Уже наверно тяжело долго ходить?</p>
                                    </div>
                                </div>
                                <div class="from-article-s clearfix">
                                    <div class="from-article-s_ava">
                                        <!-- ava--><a href="http://www.happy-giraffe.ru/user/246395/" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/v2/crops/avatarMedium/44/d5/ba3f55a8b4dde7f7f568177f9e44.jpg" class="ava_img"></a>
                                    </div>
                                    <div class="from-article-s_hold">
                                        <div class="from-article-s_head"><a href="http://www.happy-giraffe.ru/user/246395/" class="a-light">Мария Алексеева</a>
                                            <time datetime="2012-12-23" class="tx-date">2 минуты назад</time>
                                        </div><a href="http://www.happy-giraffe.ru/user/246395/blog/post241539/" class="from-article-s_t">♥23-24 февраля♥</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- / комментарий-->

                </ul>
            </div>
        </div>
    </div>
</div>
<div class="contest-commentator-rule">
    <h2 class="contest-commentator_t">Правила конкурса</h2>
    <ol class="contest-commentator-rule_ol">
        <li class="contest-commentator-rule_li">
            <h3 class="contest-commentator-rule_t-sub">1. &nbsp; Общие правила проведения Конкурса</h3>
            <ol>
                <li>
<!--                    Конкурс проводится с --><?//=Yii::app()->dateFormatter->format('dd.MM.yyyy', $this->contest->startDate)?><!-- по --><?//=Yii::app()->dateFormatter->format('dd.MM.yyyy', $this->contest->endDate)?><!-- на сайте <a href="#">http://www.happy-giraffe.ru</a>.-->
                </li>
                <li>
                    Организаторы Конкурса - Сайт для всей семьи “Веселый Жираф” <a href="#">http://www.happy-giraffe.ru</a>.
                </li>
                <li>Участником конкурса могут быть граждане, проживающие на территории России, Украины, Казахстана, Белоруссии и Армении.</li>
                <li>Анкета Участника должна быть максимально заполненной с загруженным фото профиля.</li>
                <li>Правила оставления комментариев (см. ниже)</li>
            </ol>
        </li>
        <li class="contest-commentator-rule_li">
            <h3 class="contest-commentator-rule_t-sub">2. &nbsp; Права и обязанности Участников Конкурса</h3>
            <ol>
                <li>Для того, чтобы принять участие в Конкурсе необходимо быть зарегистрированным пользователем и иметь максимально заполненную анкету с загруженной личной фотографией.</li>
                <li>Участникам необходимо писать комментарии к любым статьям на нашем сайте. Внизу каждой статьи есть поле для комментариев.</li>
                <li>Комментарии должны быть яркие, содержательные и осмысленные. Слишком короткие комментарии, ограничивающиеся двумя - тремя словами к участию Конкурса не допускаются - проходной минимум 40 знаков.</li>
                <li>Добавленный видео ролик или загруженное изображение к комментарию будет приравниваться к полноценному предложению. Но, с условием - изображение или видео должны соответствовать основной теме страницы.</li>
                <li>Так же, не допускаются комментарии, унижающие чье-либо достоинство или с не нормативной лексикой (даже если слово «литературное») - автор данных комментариев отправляется в черный список и не сможет больше участвовать в Конкурсе.</li>
                <li>Запрещается писать бессмысленные сообщения, которые не несут смысловые нагрузки, а так же оставление спама и других сторонних ссылок.</li>
                <li>Запрещено копировать комментарии других пользователей, а также копировать тексты с чужих сайтов.</li>
                <li>Набранные баллы за комментарии обновляются каждые 10 минут.</li>
                <li>Участие в Конкурсе могут принимать лица достигшие 18 лет.</li>
                <li>К участию в Конкурсе не допускаются:
                    <p>- сотрудники и представители Организаторов;</p>
                    <p>- лица, способные повлиять на их деятельность;</p>
                    <p>- члены их семей;</p>
                    <p>- работники других юридических лиц, причастных к организации и проведению Конкурса.</p>
                </li>
                <li>Каждый комментарий будет проходить обязательную модерацию. Участник будет извещен в случае, если его комментарий не будет проходить по конкурсу.</li>
            </ol>
        </li>
        <li class="contest-commentator-rule_li">
            <h3 class="contest-commentator-rule_t-sub">3. &nbsp;  Наградной фонд</h3>
            <ol>
                <li>Наградной фонд Конкурса формируется за счет средств Организатора Конкурса.</li>
                <li>Победители будут определяться количеством и качеством комментариев.</li>
                <li>В конце Конкурса будут подведены итоги и первые 10 суперактивных комментаторов получат приз в размере 1000 рублей на счет мобильного телефона.</li>
                <li>В последний день Конкурса все комментарии, которые были добавлены с частотой менее минуты для накрутки результатов будут считаться 1:2. Таким образом, статистика Участника уменьшится в половину.</li>
                <li>Минимум, который необходимо написать для получения приза - 500 комментариев. Участники в ТОП-10 не написавшие данный минимум за весь период Конкурса - приз не получают.</li>
            </ol>
        </li>
        <li class="contest-commentator-rule_li">
            <h3 class="contest-commentator-rule_t-sub">4. &nbsp;  Порядок проведения Конкурса и объявление результатов</h3>
            <ol>
                <li>
                    Все комментарии участники Конкурса оставляют под темами сайта
                    <a href="#">http://www.happy-giraffe.ru</a>.
                </li>
                <li>Победителями Конкурса станут первых 10 человек, согласно итоговому подсчету максимального количества комментариев.</li>
                <li>Информация о Победителях будет опубликована на сайте в течении двух недель после завершения конкурса.</li>
                <li>Администрация сайта направит победившим Участникам уведомление на электронный адрес в течении двух недель после завершения конкурса.</li>
                <li>Организаторы Конкурса не несут ответственности за неполучение приза Победителем в случае, если с ним не удается связаться по указанным им контактам (отключен телефон, вне зоны доступа, отключен интернет и т.п)</li>
                <li>Контактные данные для получения приза должны быть предоставлены не позже,  чем через две недели после оглашения результатов Конкурса.</li>
            </ol>
        </li>
        <li class="contest-commentator-rule_li">
            <h3 class="contest-commentator-rule_t-sub">4. &nbsp;  Иные условия проведения конкурса</h3>
            <ol>
                <li>Организаторы Конкурса гарантируют неразглашение информации о номерах телефонов и других данных Участников без их ведома.</li>
                <li>Организатор Конкурса гарантирует использование полученных данных Участников только по прямому назначению, согласно правилам Конкурса.</li>
            </ol>
        </li>
    </ol>
</div>