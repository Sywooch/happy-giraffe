<?php $this->beginContent('//layouts/new'); ?>

    </div>
    <div class="nav-hor clearfix">
        <ul class="nav-hor_ul">
            <li class="nav-hor_li">
                <a href="" class="nav-hor_i">
                <span class="nav-hor_tx">
                <span class="ico-best ico-best__interest"></span>
                Самое интересное
                </span>
                </a>
            </li>
            <li class="nav-hor_li active">
                <a href="" class="nav-hor_i">
                <span class="nav-hor_tx">
                <span class="ico-best ico-best__blog"></span>
                Блоги на главную
                </span>
                </a>
            </li>
            <li class="nav-hor_li">
                <a href="" class="nav-hor_i">
                <span class="nav-hor_tx">
                <span class="ico-best ico-best__social"></span>
                Посты в соцсети
                </span>
                </a>
            </li>
            <li class="nav-hor_li">
                <a href="" class="nav-hor_i">
                <span class="nav-hor_tx">
                <span class="ico-best ico-best__mail"></span>
                Посты в рассылку
                </span>
                </a>
            </li>
        </ul>
    </div>

<?= $content; ?>

<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
    <script type="text/javascript">
        var EditFavourites = {
            remove: function (id, el) {
                $.post('/best/remove/', {id: id}, function (response) {
                    if (response.status) {
                        $(el).parents('li').remove();
                    }
                }, 'json');
            }
        }
    </script>

<?php $this->endContent(); ?>