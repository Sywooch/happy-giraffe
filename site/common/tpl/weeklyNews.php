<?php
/* @var $this Controller
 * @var $models CommunityContent[]
 */
$remowax = date("Y-m-d") == '2014-09-12' || date("Y-m-d") == '2014-09-15' | date("Y-m-d") == '2014-09-16';
$i = 0;
?>

<?php if ($remowax): ?>
    <table style="width:100%;margin-bottom:50px;" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top">


                <div style="border:1px solid #e7e7e7;">

                    <table style="width:100%;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td valign="top" style="width: 290px;padding:10px;">
                                <table cellpadding="0" cellspacing="0" style="margin-bottom:8px;">
                                    <tr>
                                        <td valign="top"><img src="http://www.happy-giraffe.ru/images/banners/ava-remowax.jpg?1" style="display:block;margin-top:-40px;-moz-border-radius:36px;-webkit-border-radius:36px;border-radius:36px;" /></td>
                                        <td valign="top">
                                            <span style="color:#38a5f4;font:12px arial, helvetica, sans-serif;margin-left:10px;vert">Ремо-Вакс</span>
                                        </td>
                                    </tr>
                                </table>

                                <div style="margin-bottom:10px;">
                                    <span style="color:#0d81d5;font:bold 18px/20px arial, helvetica, sans-serif;"><a href="http://ads.adfox.ru/211012/goLink?p2=exim&p1=bndzr&p5=cklrq&pr=evnyzjo" target="_blank" style="color:#0d81d5;font:bold 22px/24px arial, helvetica, sans-serif;">Чистим уши ребенку без хлопот и боли!</a></span>
                                </div>
                                <!--
                                <div style="margin-bottom:5px;">
                                    <span style="color:#b6b9ba;font:9px tahoma, arial, helvetica, sans-serif;">21 марта 2012, 13:25</span>
                                </div> -->
                                <!--
                                <div style="margin-bottom:5px;">
                                    <a href="" target="_blank" style="text-decoration: none;"><img src="http://dev.happy-giraffe.ru/images/mail/img_01.jpg" width="318" border="0" style="display:block;" /></a>
                                </div> -->

                                <div style="font:13px/18px arial, helvetica, sans-serif;color:#040404;">На родителях всегда лежит большая ответственность, – нужно внимательно следить за гигиеной своего малыша ...  </div>
                                <div style="margin: 20px 0;">
                                    <a href="http://ads.adfox.ru/211012/goLink?p2=exim&p1=bndzr&p5=cklrq&pr=evnyzjo" style="color: #ffffff; background: #4fb044; padding: 10px 16px;text-decoration:none;font:16px/22px arial, helvetica, sans-serif;">Узнать больше!</a>
                                </div>
                            </td>
                            <td>
                                <img src="http://www.happy-giraffe.ru/images/mail/post-199812.jpg" alt="" />
                            </td>
                        </tr>
                    </table>
                </div>

            </td>
        </tr>
    </table>
<?php endif; ?>

<table style="width:100%;margin-bottom:50px;" cellpadding="0" cellspacing="0">
    <tbody><tr>
        <?php foreach ($models as $model): ?>
    <td style="width:340px;<?php if ($i % 2 != 0) echo "padding-left:20px" ?>" valign="top">

            <div style="padding:10px;border:1px solid #e7e7e7;width:318px;">

                <table cellpadding="0" cellspacing="0" style="margin-bottom:8px;">
                    <tbody>
                    <tr>
                        <td valign="middle"><img src="<?php echo ($ad = $model->isAd()) ? ('http://www.happy-giraffe.ru' . $ad['img']) : $model->author->getAvatarUrl() ?>"
                                                 style="display:block;margin-top:-40px;-moz-border-radius:36px;-webkit-border-radius:36px;border-radius:36px;">
                        </td>
                        <td valign="top">
                            <span style="color:#38a5f4;font:12px arial, helvetica, sans-serif;margin-left:10px;"><?php echo ($ad = $model->isAd()) ? $ad['text'] : $model->author->first_name ?></span>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div style="margin-bottom:10px;">
                <span style="color:#0d81d5;font:bold 18px/20px arial, helvetica, sans-serif;">
                    <a href="http://www.happy-giraffe.ru<?php echo ltrim($model->getUrl(), '.') ?>?utm_source=email" target="_blank" style="color:#0d81d5;font:bold 18px/20px arial, helvetica, sans-serif;"><?php echo $model->title ?></a></span>
                </div>

                <div style="margin-bottom:5px;">
                    <span style="color:#b6b9ba;font:9px tahoma, arial, helvetica, sans-serif;"><?php echo  Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $model->created); ?></span>
                </div>

                <?php
                $image_url = $model->getContentImage(580, 1000);
                if (!empty($image_url))
                    $image_size = getimagesize($image_url);
                else
                    $image_size = array(0);
                if ($image_size[0]>100){
                ?>
                <div style="margin-bottom:5px;">
                    <a href="http://www.happy-giraffe.ru<?php echo ltrim($model->getUrl(), '.') ?>?utm_source=email" target="_blank" style="text-decoration: none;">
                        <img src="<?php echo $image_url ?>" width="318" border="0" style="display:block;"></a>
                </div>
                <?php } ?>

                <div style="font:13px/18px arial, helvetica, sans-serif;color:#040404;">
                    <?php echo  $model->getContentText(450); ?>
                    <span style="color:#0d81d5;">
                    <a href="http://www.happy-giraffe.ru<?php echo ltrim($model->getUrl(), '.') ?>?utm_source=email" target="_blank" style="color:#0d81d5;">Читать&nbsp;всю&nbsp;запись&nbsp;<img
                        src="http://www.happy-giraffe.ru/images/mail/icon_more.gif" style="margin-left:5px;"></a>
                </span>
                </div>

                <table cellpadding="0" cellspacing="0" style="margin-top:20px;">
                    <tbody>
                    <tr>
                        <td style="padding-right:10px;">
                        <span style="color:#737575;font:12px arial, helvetica, sans-serif;">
                            <img src="http://www.happy-giraffe.ru/images/mail/icon_views.gif"
                                 style="margin-right:5px;vertical-align:top;"><?php echo PageView::model()->viewsByPath(ltrim($model->url, '.'), true); ?>
                        </span>
                        </td>
                        <td style="padding-right:15px;">
                        <span style="color:#31a4f6;font:12px arial, helvetica, sans-serif;">
                            <a href="http://www.happy-giraffe.ru<?php echo ltrim($model->getUrl(), '.') ?>?utm_source=email#comment_list" target="_blank" style="color:#31a4f6;font:12px arial, helvetica, sans-serif;"><img
                                src="http://www.happy-giraffe.ru/images/mail/icon_comments.gif"
                                style="margin-right:5px;vertical-align:top;"><?php echo $model->getCommentsCount() ?></a></span>
                        </td>
                        <td>
                            <?php $used = array(); ?>
                            <?php $j = 0; foreach ($model->getUnknownClassComments() as $comment): ?>
                            <?php if (!empty($comment->author->avatar_id) && !in_array($comment->author->avatar_id, $used)):?>
                                <?php $j++;$used[] = $comment->author->avatar_id ?>
                                <img src="<?php echo $comment->author->getAvatarUrl(Avatar::SIZE_MICRO) ?>"
                                     style="margin-right:5px;-moz-border-radius:12px;-webkit-border-radius:12px;border-radius:12px;">
                                <?php if ($j == 5) break; ?>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>

    </td>
    <?php $i++; ?>
        <?php if ($i % 2 == 0 && $i != count($models)):?>
                        </tr>
                    </tbody>
                </table>
                    <table style="width:100%;margin-bottom:50px;" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                <?php endif ?>
    <?php endforeach; ?>

        </tr>
    </tbody>
</table>