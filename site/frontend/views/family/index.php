<?php
    /* @var $this Controller
     * @var $user User
     * @var $future_baby Baby
     */
    $js = '
        Family.userId='.$user->id.';
        Family.partner_id='.$user->partner->id.';
        Family.partnerOf = '.CJavaScript::encode($user->getPartnerTitlesOf()).';
        Family.baby_count = '.$user->babyCount().';
        Family.relationshipStatus = '.(($user->relationship_status === null) ? 'null' : $user->relationship_status).';
    ';

    $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
    $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

    Yii::app()->clientScript->registerScript('family-edit',$js)
        ->registerScriptFile($baseUrl. '/family.js?35', CClientScript::POS_HEAD);
?>

<div class="user-cols clearfix">

    <div class="col-1">

        <div class="clearfix user-info-big">
            <div class="user-info">
                <div class="ava female"></div>
                <div class="details">
                    <span class="icon-status status-online"></span>
                    <a href="" class="username">Александр Богоявленский</a>
                </div>
                <div class="user-fast-nav">
                        <ul>
                            <a href="">Анкета</a>&nbsp;|&nbsp;<a href="">Блог</a>&nbsp;|&nbsp;<a href="">Фото</a>&nbsp;|&nbsp;<a href="">Что нового</a>&nbsp;|&nbsp;<span class="drp-list"><a href="" class="more">Еще</a><ul><li><a href="">Семья</a></li><li><a href="">Друзья</a></li></ul>
                            </span>

                        </ul>
                    </div>
                <div class="text-status">
                    <p>Привет всем! У меня все ok! Единственное, что имеет значение.</p>
                    <span class="tale"></span>
                </div>
            </div>
        </div>

        <div class="user-family">
            <div class="t"></div>
            <div class="c">
                <ul>
                    <li>
                        <big>Катя <small>-&nbsp;моя&nbsp;невеста</small></big>
                        <div class="comment blue">
                            Очень любит готовить, заниматься с детьми, очень добрая и отзывчивая
                            <span class="tale"></span>
                        </div>
                        <div class="img">
                            <img src="/images/example/ex1.png" />
                        </div>
                    </li>
                    <li>
                        <big>Вильгельмина <small>-&nbsp;моя&nbsp;невеста</small></big>
                        <div class="comment">
                            Очень любит готовить, заниматься с детьми, очень добрая и отзывчивая
                            <span class="tale"></span>
                        </div>
                        <div class="img">
                            <img src="/images/example/ex2.png" />
                        </div>
                    </li>
                    <li>
                        <big>Артем <small>- мой сын, 10 лет</small></big>
                        <div class="comment">
                            Очень любит готовить, заниматься с детьми, очень добрая и отзывчивая
                            <span class="tale"></span>
                        </div>
                        <div class="img">
                            <img src="/images/example/ex3.jpg" />
                        </div>
                    </li>
                    <li class="waiting clearfix">
                        <i class="icon"></i>
                        <div class="in">
                            <big>Ждем еще</big>
                            <div class="gender">Девочку <i class="icon-female"></i></div>
                            <div class="time">7-я неделя</div>
                        </div>
                    </li>

                </ul>

                <a href="" class="watch-album">Смотреть семейный<br/>альбом</a>

            </div>
            <div class="b"></div>
        </div>

    </div>

    <div class="col-23 clearfix">

        <div class="family">

            <div class="content-title-new">Моя семья</div>

            <div class="family-radiogroup">
                <div class="title">Семейное положение<span class="relationship-status"<?php if ($user->relationship_status === null): ?> style="display: none;"<?php endif; ?>> <span class="title"><?=$user->relationshipStatusString?></span> <a href="javascript:void(0)" class="pseudo" onclick="Family.changeStatus()">Изменить</a></span></div>
                <div class="relationship-choice"<?php if ($user->relationship_status !== null): ?> style="display: none;"<?php endif; ?>>
                    <div class="subtitle">Выберите один из вариантов вашего семейного положения.</div>
                    <div class="radiogroup">
                        <?php foreach ($user->getRelashionshipList() as $status_key => $status_text): ?>
                            <div class="radio-label<?php if ($user->relationship_status == $status_key) echo ' checked' ?>" onclick="Family.setStatusRadio(this, <?=$status_key ?>);"><span><?=$status_text ?></span><input type="radio" name="radio-<?=$status_key ?>"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="family-member" id="user-partner"<?php if (!$user->hasPartner()) echo ' style="display:none;"' ?>>

                <p>Расскажите немного о вашей невесте и загрузите её фото (по желанию)</p>

                <div class="data clearfix">

                    <div class="d-text">Имя <span><?=$user->getPartnerTitleOf() ?></span>:</div>

                    <div class="name">
                        <div class="text"<?php if (empty($user->partner->name)) echo ' style="display:none;"' ?>><?=$user->partner->name ?></div>
                        <div class="input"<?php if (!empty($user->partner->name)) echo ' style="display:none;"' ?>>
                            <input type="text">
                            <button class="btn btn-green-small" onclick="Family.savePartnerName(this);"><span><span>Ok</span></span></button>
                        </div>
                        <a href="javascript:void(0);" onclick="Family.editPartnerName(this)" class="edit tooltip"<?php if (empty($user->partner->name)) echo ' style="display:none;"' ?> title="Редактировать имя"></a>
                    </div>
                </div>

                <div class="data clearfix">
                    <div class="d-text">О <span><?=$user->getPartnerTitleOf(null, 1) ?></span>:</div>
                    Добавьте короткий рассказ (не более 100 знаков)
                    <div class="comment">
                        <span class="tale"></span>
                        <div class="input"<?php if (! empty($user->partner->notice)) echo ' style="display:none;"' ?>>
                            <textarea><?=$user->partner->notice?></textarea>
                            <button class="btn btn-green-small" onclick="Family.savePartnerNotice(this)"><span><span>Ok</span></span></button>
                        </div>
                        <div class="text"<?php if (empty($user->partner->notice)) echo ' style="display:none;"' ?>>
                            <span class="text"><?=$user->partner->notice?></span>
                            <a href="javascript:void(0);" onclick="Family.editPartnerNotice(this, false)" class="edit tooltip" title="Редактировать"></a>
                            <a href="javascript:void(0);" onclick="Family.editPartnerNotice(this, true)" class="remove tooltip" title="Удалить"></a>
                        </div>
                    </div>
                </div>

                <div class="data clearfix">

                    <div class="d-text">Фото <span><?=$user->getPartnerTitleOf() ?></span>:</div>
                    Загрузите фото, нажав на кнопку “+”

                    <div class="gallery-photos-new cols-3 clearfix">
                        <ul>

                            <li class="add">
                                <?php
                                    $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                                        'model' => $user->partner,
                                        'customButton' => true,
                                    ));
                                ?>
                                <i class="icon"></i>
                                <span>Загрузить  еще фото</span>
                                <?php
                                    $this->endWidget();
                                ?>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>