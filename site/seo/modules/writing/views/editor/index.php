<div class="search clearfix">

    <div class="input">
        <label>Введите слово или фразу</label>
        <input name="keyword" id="keyword" type="text">
        <button class="btn btn-green-small" onclick="SeoKeywords.term = $(this).prev().val();SeoKeywords.searchKeywords();return false;">
            <span><span>Поиск</span></span></button>
    </div>

    <div class="result">

    </div>

    <div class="result-filter">
        <label for="hide-used">не показывать<br>используемые<br>
            <input type="checkbox"
                   id="hide-used" <?php if (Yii::app()->user->getState('hide_used') == 1) echo 'checked="checked"' ?>
                   onchange="SeoKeywords.hideUsed(this);">
        </label>
    </div>

</div>

<div class="seo-table table-result">
    <div class="table-box">
        <table>
            <thead>
            <tr>
                <th rowspan="2" class="col-1" style="width:350px;">Ключевое слово или фраза</th>
                <th rowspan="2"><i class="icon-freq"></i></th>
                <th colspan="2">Частота показов</th>
<!--                <th colspan="2"><i class="icon-comments"></i></th>-->
                <th colspan="2">Конкуренты</th>
                <th rowspan="2">Действие</th>
            </tr>
            <tr>
                <th><i class="icon-yandex"></i></th>
<!--                <th><i class="icon-google"></i></th>-->
                <th><i class="icon-yandex-2"></i></th>
<!--                <th><i class="icon-rambler"></i></th>-->
<!--                <th><i class="icon-yandex"></i></th>-->
<!--                <th><i class="icon-google"></i></th>-->
                <th><i class="icon-babyru"></i></th>
                <th><i class="icon-babyru-2"></i></th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<div class="pagination pagination-center clearfix">

</div>
<script type="text/javascript">
    $(function() {
        $('#keyword').keypress(function(e){
            if(e.which == 13){
                SeoKeywords.term = $(this).val();
                SeoKeywords.searchKeywords();
            }
        });

        $('body').delegate('.yiiPager li.page a', 'click', function(e){
            var myRe = /.\/(\d+)\//ig;

            var page = myRe.exec($(this).attr('href'));
            page = page[1];
            SeoKeywords.page = page - 1;
            SeoKeywords.searchKeywords();

            return false;
        });
    });
</script>