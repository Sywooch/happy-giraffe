<div class="b-article-conversion clearfix">
    <a href="javascript:;" class="a-pseudo b-article-conversion_hide" onclick="HidePopular()">Скрыть</a>
    <div class="heading-title textalign-c clearfix"> <span class="ico-crown"></span> Популярные посты</div>

    <?php foreach($posts as $post)
              $this->render('application.views.site._article', array('model' => $post)) ?>
</div>
<script type="text/javascript">
    var HidePopular = function () {
        $.post('/my/hidePopular/', function (response) {
            if (response.success)
                $('.b-article-conversion').remove();
        }, 'json');
    }
</script>