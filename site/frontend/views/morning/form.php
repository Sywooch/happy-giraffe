<?php
/* @var $this Controller
 * @var $post CommunityContent
 */
?><script type="text/javascript"
        src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCk--cFAYpjqqxmbabeV9IIlwbmnYlzHfc&sensor=false">
</script>
<script type="text/javascript">
    var model_id = <?= ($post->isNewRecord) ? 'null' : $post->id ?>;
</script>

<div class="morning-edit form">
    <div class="inner-title">Заголовок статьи</div>

    <div class="name clearfix">
        <div class="text"<?php if (empty($post->title)) echo ' style="display:none;"' ?>><?=$post->title ?></div>
        <div class="input"<?php if (!empty($post->title)) echo ' style="display:none;"' ?>>
            <input type="text">
            <button class="btn btn-green-small" onclick="Morniing.saveField(this, 'title');"><span><span>Ok</span></span>
            </button>
        </div>
        <a href="javascript:void(0);" onclick="Morniing.editField(this)" class="edit tooltip" title="Редактировать название"></a>
    </div>
    <br>

    <div class="inner-title">Позиция</div>
    <div class="pos clearfix">
        <div class="text"><?=$post->morningPost->position ?></div>
        <div class="input" style="display:none;">
            <input type="text" value="<?=$post->morningPost->position ?>">
            <button class="btn btn-green-small" onclick="Morniing.savePos(this);"><span><span>Ok</span></span>
            </button>
        </div>
        <a href="javascript:void(0);" onclick="Morniing.editField(this)" class="edit tooltip" title="Редактировать позицию"></a>
    </div>

    <div<?php if (empty($post->title)) echo ' style="display:none;"' ?>>

        <div class="inner-title">Превью</div>

        <div class="name clearfix">
            <div
                class="text"<?php if (empty($post->preview)) echo ' style="display:none;"' ?>><?=$post->preview ?></div>
            <div class="input"<?php if (!empty($post->preview)) echo ' style="display:none;"' ?>>
                <textarea rows="5" cols="35"></textarea>
                <button class="btn btn-green-small" onclick="Morniing.saveField(this, 'preview');"><span><span>Ok</span></span>
                </button>
            </div>
            <a href="javascript:void(0);" onclick="Morniing.editField(this)"
               class="edit tooltip"<?php if (empty($post->preview)) echo ' style="display:none;"' ?> title="Редактировать текст превью"></a>
        </div>

        <br>
        <div class="inner-title">Где</div>

        <div class="location clearfix">
            <?php $this->renderPartial('_loc',compact('post')); ?>
        </div>
        <br><br>
        <div class="photos">
            <div>
                <?php foreach ($post->morningPost->photos as $photo): ?>
                <?php $this->renderPartial('_photo', compact('photo')); ?>
                <?php endforeach; ?>

                <div class="add">
                    <a href="javascript:void(0);" class="fake_file">

                        <i class="icon"></i>
                        <span>Загрузить еще</span>
                        <?php $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'photo_upload',
                            'action' => $this->createUrl('uploadPhoto'),
                            'htmlOptions' => array(
                                'enctype' => 'multipart/form-data',
                            ),
                        )); ?>
                        <?php echo CHtml::hiddenField('id', $post->morningPost->id); ?>
                        <?php echo CHtml::fileField('file', '', array('class'=>'photo-file')); ?>
                        <?php $this->endWidget(); ?>
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .morning-main {
        float: none;
        width: auto;
    }
    .morning-edit .inner-title {
        color: #0281B0;
        font: bold 25px arial,helvetica,sans-serif;
        padding-bottom: 10px;
    }
    .morning-edit .location .text, .morning-edit .location img {
        float: left;
    }
    .morning-edit textarea{
        width: 600px;
        height: 130px;
        font-size: 12px;
    }

    .morning-edit .name .text {
        float: left;
        max-width: 700px;
        font-size: 14px;
    }

    .morning-edit input[type=text] {
        width: 700px;
    }

    .morning-edit .edit {
        background: url("/images/common.png") no-repeat scroll -383px -204px transparent;
        display: block;
        float: left;
        font-weight: normal;
        height: 18px;
        margin: 0 auto 0 5px;
        position: relative;
        text-decoration: none;
        width: 14px;
        z-index: 3;
    }

    .morning-edit .remove {display: block;
        float: left;
        font-weight: normal;
        height: 18px;
        margin: 0 auto 0 5px;
        position: relative;
        text-decoration: none;
        width: 14px;
        height: 14px;
        z-index: 3;
        background:url(/images/common.png) no-repeat -314px -135px;
    }
    .morning-edit .remove:hover {background-position:-314px -148px;}

    .morning-edit .edit:hover {
        background-position: -341px -136px;
    }

    .morning-edit .photos div div{
        margin-bottom: 20px;
    }

    .morning-edit .photos .remove {
        background: url("/images/common.png") no-repeat scroll -2px -101px transparent;
        display: block;
        height: 18px;
        position: absolute;
        right: 0;
        top: 0;
        width: 20px;
    }

    .morning-edit .photos div.add {
        line-height: normal;
        text-align: center;
    }
    .morning-edit .photos div.add a {
        background: url("/images/gallery_photos_add.png") no-repeat scroll 0 0 transparent;
        display: block;
        height: 50px;
        overflow: hidden;
        padding-top: 60px;
        position: relative;
        text-decoration: none;
        width: 148px;
    }
    .morning-edit .photos div.add a:hover .icon {
        background-position: -429px -191px;
    }
    .morning-edit .photos div.add a .icon {
        background: url("/images/common.png") no-repeat scroll -464px -191px transparent;
        display: block;
        height: 33px;
        left: 50%;
        margin-left: -16px;
        position: absolute;
        top: 20px;
        width: 33px;
    }
    .morning-edit .photos div.add a span {
        border-bottom: 1px dashed #1B98C5;
        margin-top: 60px;
    }
    .morning-edit .photos div.add a:hover span {
        border: 0 none;
    }
    .morning-edit .photos div.add a input[type="file"] {
        display: block;
        height: 100%;
        opacity: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: 210px;
        z-index: 3;
    }

    .morning-edit .photos ul {
        overflow: hidden;
    }

    .morning-edit .photos img{
        width: 200px;
        height: 140px;
    }
</style>