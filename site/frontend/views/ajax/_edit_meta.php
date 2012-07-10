<?php
/**
 * Author: alexk984
 * Date: 04.07.12
 *
 * @var PageMetaTag $model
 * @var CActiveDataProvider $dataProvider
 */
?>
<div id="seo_tags" class="popup">

    <a href="javascript:void(0);" class="popup-close tooltip" onclick="$.fancybox.close();"></a>

    <div class="block-title">
        Мета-теги
        <span><?=isset($page) ? $page->getArticleTitle() : '' ?></span>
    </div>

    <div class="clearfix" id="phrase-table">

        <div class="pagination">
            <?php if (isset($dataProvider)) {

            $count = PagesSearchPhrase::model()->count($dataProvider->getCriteria());
            $pages = new CPagination($count);
            $pages->pageSize = 7;
            $pages->applyLimit($dataProvider->getCriteria());

            $this->widget('MyLinkPager', array(
                'header' => false,
                'pages' => $pages,
            ));
        }?>
        </div>

        <div class="seo-table table-result table-promotion">

            <div class="table-box">
                <table>
                    <thead>
                    <tr>
                        <th rowspan="2" class="col-1">Ключевые слова и фразы</th>
                        <th colspan="3"><i class="icon-yandex"></i></th>
                        <th colspan="2"><i class="icon-google"></i></th>
                        <th rowspan="2">Общие визиты</th>
                    </tr>
                    <tr>
                        <th>Частота</th>
                        <th>Позиции</th>
                        <th>Визиты</th>
                        <th>Позиции</th>
                        <th>Визиты</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $this->renderPartial('_article_visits', compact('model', 'dataProvider')); ?>

                    </tbody>

                </table>
            </div>

        </div>


    </div>

    <form action="/ajax/editMeta/" method="post" id="edit-meta-tags" class="seo-tags">
        <input type="hidden" value="<?=$model->_id ?>" name="_id">

        <div class="row clearfix">
            <div class="row-title"><label>Title:</label></div>
            <div class="row-elements">
                <textarea name="meta[title]" id="meta_title" cols="60" rows="4"><?=$model->title ?></textarea>
            </div>
        </div>

        <div class="row clearfix">
            <div class="row-title"><label>Keywords:</label></div>
            <div class="row-elements">
                <textarea name="meta[keywords]" id="meta_keywords" cols="60" rows="4"><?=$model->keywords ?></textarea>
            </div>
        </div>

        <div class="row clearfix">
            <div class="row-title"><label>Description:</label></div>
            <div class="row-elements">
                <textarea name="meta[description]" id="meta_description" cols="60"
                          rows="4"><?=$model->description ?></textarea>
            </div>
        </div>

        <div class="row row-btn">
            <input type="submit" onclick="return EditMetaTags.submit();">
        </div>

    </form>
</div>
<script type="text/javascript">
    var EditMetaTags = {
        submit:function () {
            $.post('/ajax/editMeta/', $('#edit-meta-tags').serialize(), function (response) {
                if (response.status) {
                    $.fancybox.close();
                }
            }, 'json');
            return false;
        },
        addKeyword:function (keyword) {
            if ($('#meta_keywords').val() == '')
                $('#meta_keywords').val(keyword);
            else
                $('#meta_keywords').val($('#meta_keywords').val() + ', ' + keyword);
        }
    }

    $(function () {
        $('body').delegate('#seo_tags li.page a', 'click', function () {
            $.post($(this).attr('href'), function (response) {
                var id = '#phrase-table';
                $(id).replaceWith($(id, '<div>' + response + '</div>'));
            });
            return false;
        });
    });
</script>
<style type="text/css">
    li.first {
        display: none !important;
    }

    li.previous {
        display: none !important;
    }
</style>