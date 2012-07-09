<?php
/**
 * Author: alexk984
 * Date: 04.07.12
 *
 * @var PageMetaTag $model
 */
?>
<form action="/ajax/editMeta/" method="post" id="edit-meta-tags">
    <input type="hidden" value="<?=$model->_id ?>" name="_id">

    <div>Title</div>
    <textarea name="meta[title]" id="meta_title" cols="60" rows="4"><?=$model->title ?></textarea>

    <div>Keywords</div>
    <textarea name="meta[keywords]" id="meta_keywords" cols="60" rows="4"><?=$model->keywords ?></textarea>

    <div>Desctiption</div>
    <textarea name="meta[description]" id="meta_description" cols="60" rows="4"><?=$model->description ?></textarea>
    <br>
    <input type="submit" onclick="return EditMetaTags.submit();">
</form>
<script type="text/javascript">
    var EditMetaTags = {
        submit:function () {
            $.post('/ajax/editMeta/', $('#edit-meta-tags').serialize(), function (response) {
                if (response.status) {
                    $.fancybox.close();
                }
            }, 'json');
            return false;
        }
    }
</script>