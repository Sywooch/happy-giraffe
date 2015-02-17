<?php
$this->beginContent('//layouts/lite/community');
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <?php
        echo $content;
        ?>
        <aside class="b-main_col-sidebar visible-md">
			<community-add params="forumId: <?= $this->forum->id ?>, clubSubscription: <?= CJSON::encode(UserClubSubscription::subscribed(Yii::app()->user->id, $this->club->id)) ?>, clubId: <?= $this->club->id ?>, subsCount: <?= (int)UserClubSubscription::model()->getSubscribersCount($this->club->id) ?>"></community-add>

            <div class="menu-simple">
                <ul class="menu-simple_ul">
                    <?php
                    foreach ($this->forum->rubrics as $rubric) {
                        // Если рубрика корневая
                        if (!$rubric->parent) {
                            $sub = '';
                            if(!empty($rubric->childs)) {
                                $sub = '<ul class="menu-simple_ul">';
                                foreach ($rubric->childs as $child) {
                                    $content = HHtml::link($child->title, $child->url, array('class' => 'menu-simple_a'));
                                    $class = 'menu-simple_li' . (($this->rubric && $this->rubric->id == $child->id) ? ' active' : '');
                                    $sub .= CHtml::tag('li', array('class' => $class), $content);
                                }
                                $sub .= '</ul>';
                            }
                            $content = HHtml::link($rubric->title, $rubric->url, array('class' => 'menu-simple_a')) . $sub;
                            $class = 'menu-simple_li' . (($this->rubric && $this->rubric->id == $rubric->id) ? ' active' : '');
                            echo CHtml::tag('li', array('class' => $class), $content);
                        }
                    }
                    ?>
                </ul>
            </div>

            <?php if ($this->action->id == 'view'): ?>
                <div class="banner">
                    <!--  AdRiver code START. Type:extension Site:  PZ: 0 BN: 0 -->
                    <script type="text/javascript">
                        (function (L) {
                            if (typeof (ar_cn) == "undefined")
                                ar_cn = 1;
                            var S = 'setTimeout(function(e){if(!self.CgiHref){document.close();e=parent.document.getElementById("ar_container_"+ar_bnum);e.parentNode.removeChild(e);}},3000);',
                                    j = ' type="text/javascript"', t = 0, D = document, n = ar_cn;
                            L = '' + ('https:' == document.location.protocol ? 'https:' : 'http:') + '' + L + escape(D.referrer || 'unknown') + '&rnd=' + Math.round(Math.random() * 999999999);
                            function _() {
                                if (t++ < 100) {
                                    var F = D.getElementById('ar_container_' + n);
                                    if (F) {
                                        try {
                                            var d = F.contentDocument || (window.ActiveXObject && window.frames['ar_container_' + n].document);
                                            if (d) {
                                                d.write('<sc' + 'ript' + j + '>var ar_bnum=' + n + ';' + S + '<\/sc' + 'ript><sc' + 'ript' + j + ' src="' + L + '"><\/sc' + 'ript>');
                                                t = 0
                                            }
                                            else
                                                setTimeout(_, 100);
                                        } catch (e) {
                                            try {
                                                F.src = "javascript:{document.write('<sc'+'ript" + j + ">var ar_bnum=" + n + "; document.domain=\""
                                                        + D.domain + "\";" + S + "<\/sc'+'ript>');document.write('<sc'+'ript" + j + " src=\"" + L + "\"><\/sc'+'ript>');}";
                                                return
                                            } catch (E) {
                                            }
                                        }
                                    } else
                                        setTimeout(_, 100);
                                }
                            }
                            D.write('<div style="visibility:hidden;height:0px;left:-1000px;position:absolute;"><iframe id="ar_container_' + ar_cn
                                    + '" width=1 height=1 marginwidth=0 marginheight=0 scrolling=no frameborder=0><\/iframe><\/div><div id="ad_ph_' + ar_cn
                                    + '" style="display:none;"><\/div>');
                            _();
                            ar_cn++;
                        })('//ad.adriver.ru/cgi-bin/erle.cgi?sid=196494&bt=49&target=blank&tail256=');
                    </script>
                    <!--  AdRiver code END  -->
                </div>
            <?php endif; ?>
        </aside>
    </div>
</div>
<?php
$this->endContent();
