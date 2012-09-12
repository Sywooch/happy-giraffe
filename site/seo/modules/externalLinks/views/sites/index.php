<div class="ext-links-add">

    <div class="nav clearfix">
        <?php

        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array(
                    'label' => 'Добавить',
                    'url' => array('/externalLinks/sites/index')
                ),
                array(
                    'label' => 'Отчеты',
                    'url' => array('/externalLinks/sites/reports'),
                ),
            )));
        ?>
    </div>

    <div class="flash-message added" style="display: none;">
        Ваша ссылка добавлена &nbsp;&nbsp; <a href="">Перейти</a>
    </div>

    <div class="check-url">
        <input id="site_url" type="text" placeholder="Введите URL сайта " />
        <button class="btn-g" onclick="ExtLinks.CheckSite()">Проверить</button>
    </div>

    <div class="url-actions" id="site_status_1" style="display: none;">

        <span class="new-site">Новый сайт</span>

        <button class="btn-g"onclick="$('div.form').show()" >Добавить</button>

        <a href="javascript:;" class="pseudo" onclick="ExtLinks.CancelSite()">Отмена</a>

        <a href="" class="icon-blacklist">ЧС</a>

    </div>

    <div class="url-actions" id="site_status_2" style="display: none;">

        <span class="have-links">Есть ссылки</span>

        <button class="btn-g disabled" onclick="$('div.form').show()">Добавить</button>

        <a href="javascript:;" class="pseudo" onclick="ExtLinks.CancelSite()">Отмена</a>

        <a href="javascript:;" class="icon-blacklist">ЧС</a>

    </div>

    <div class="url-actions" id="site_status_3" style="display: none;">

        <span class="in-blacklist">В черном списке</span>

        <button class="btn-g orange" onclick="ExtLinks.CancelSite()">Отмена</button>

        <a href="javascript:;" onclick="$('div.form').show()" class="pseudo">Добавить</a>

    </div>

    <div class="url-list" style="display: none;">

        <ul>
            <li><a href=""></a></li>
        </ul>

    </div>

    <div class="form" style="display: none;">

        <div class="row">
            <div class="row-title">
                <span>Внешний сайт</span> - адрес страницы <small>(на которой проставлена ссылка)</small>
            </div>
            <div class="row-elements">
                <input type="text" placeholder="Введите URL" />
            </div>
        </div>

        <div class="row">
            <div class="row-title">
                <span>Наш сайт</span> - адрес статьи / сервиса <small>(которые мы продвигаем)</small>
            </div>
            <div class="row-elements">
                <input type="text" placeholder="Введите URL" />
            </div>
        </div>

        <div class="row">
            <div class="row-title">
                <span>Анкор</span>
            </div>
            <div class="row-elements">
                <input type="text" /> <a href="" class="icon-btn-add"></a>
                <input type="text" />
            </div>
        </div>

        <div class="row">
            <div class="row-title">
                <span>Кто поставил</span>
            </div>
            <div class="row-elements">
                <div class="col">
                    <select>
                        <option></option>
                    </select>
                </div>
                <div class="col">
                    <input type="text" class="date" placeholder="Дата" /> <a href="" class="icon-date"></a>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="row-title">
                <span>Тип ссылки</span>
						<span class="link-types">
							<a href="" class="icon-link link">С</a> - ссылка
							<a href="" class="icon-link comment">К</a> - комментарий
							<a href="" class="icon-link post">П</a> - постовой
						</span>
            </div>
        </div>

        <div class="row">
            <div class="row-title">
                <span>Платная</span>
                <span class="title-cost">Стоимость</span>
                <span class="title-sys">Система</span>

            </div>
            <div class="row-elements">
                <div class="col col-free">
                    <input type="checkbox" />
                </div>
                <div class="col col-cost">
                    <input type="text" /> руб.
                </div>
                <div class="col col-sys">
                    <select>
                        <option></option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row row-btn">
            <button class="btn-g">Добавить</button>
        </div>

    </div>

</div>