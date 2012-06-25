<?php

foreach ($article_keyword->keywordGroup->keywords as $keyword) {
    ?>
<div class="title"><?=$keyword->name ?></div>
<table>
    <tr>
        <td><?php
            $allSearch = Yii::app()->search->select('*')->from('community')->where('* ' . $keyword->name . ' *')->limit(0, 30)->searchRaw();

            foreach ($allSearch['matches'] as $key => $m) {
                $article = CommunityContent::model()->findByPk(trim($key));
                if ($article !== null && !$linkingPage->hasLinkFrom('CommunityContent', $key)) {
                    echo CHtml::link($article->title, 'http://happy-giraffe.com' . $article->url);?>
                    <a href="javascript:;" class="btn-green-small"
                       onclick="SeoLinking.AddLink(this, <?= $linkingPage->id ?>, <?= $article->id ?>);">OK</a>
                        <?=LinkingPages::OutLinksCount('CommunityContent', $key); ?>
                    <br>
                    <?php
                }
            }

            ?></td>
        <td><?php

            $allSearch = Yii::app()->search->select('*')->from('keywords')->where('* ' . $keyword->name . ' *')->limit(0, 30)->searchRaw();

            foreach ($allSearch['matches'] as $key => $m) {
                $keyword = Keyword::model()->findByPk(trim($key));
                if ($keyword !== null && !$linkingPage->hasLinkKeyword($key)) {
                    ?>

                    <a href="javascript:;" class="keyword-for-link" id="keyword-<?= $keyword->id ?>"
                       onclick="SeoLinking.CheckKeyword(this, <?= $keyword->id ?>);"><?= $keyword->name?></a>
                    <br>
                    <?php
                }
            }
            ?></td>
    </tr>
</table>


<?php
}
