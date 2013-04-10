<div class="horoscope" xmlns="http://www.w3.org/1999/html">
    <div class="margin-b10">
				<span class="color-lilac">
				&larr;  <a href="<?=$this->createUrl('/horoscope/index')?>" class="color-lilac text-small">Гороскоп все знаки</a>
				</span>
    </div>
    <h1 class="horoscope_h1"><?=$title?></h1>
    <div class="horoscope-one clearfix">
        <div class="horoscope-one_img">
            <img src="/images/services/horoscope/big/<?=$model->zodiac?>.png" alt="" />
        </div>
        <div class="horoscope-one_hold">
            <div class="horoscope-one_desc"><?=$model->zodiacText()?></div>
            <div class="horoscope-one_date"><?=$model->zodiacDates()?></div>
        </div>
    </div>
    <div class="horoscope-links clearfix">
        <div class="horoscope-links_hold">
            <div class="horoscope-links_i">
                <a href="<?=$this->createUrl('view', array('zodiac' => $model->getZodiacSlug()))?>" class="horoscope-links_a">На сегодня</a>
            </div>
            <div class="horoscope-links_i">
                <a href="<?=$this->createUrl('view', array('type' => 'tomorrow', 'zodiac' => $model->getZodiacSlug()))?>" class="horoscope-links_a">На завтра</a>
            </div>
        </div>
        <div class="horoscope-links_hold">
            <div class="horoscope-links_i">
                <a href="<?=$this->createUrl('view', array('type' => 'month', 'zodiac' => $model->getZodiacSlug()))?>" class="horoscope-links_a">На месяц</a>
            </div>
            <div class="horoscope-links_i">
                <a href="<?=$this->createUrl('view', array('type' => 'year', 'zodiac' => $model->getZodiacSlug()))?>" class="horoscope-links_a">На 2012</a>
            </div>
        </div>
    </div>

    <div class="layout-hold margin-b10 clearfix">
        <?php if ($type == 'today' || $type == 'tomorrow'): ?>
            <div class="horoscope-paper">
                <div class="horoscope-paper_date"><?=date("j", strtotime($model->date)) ?></div>
                <div class="horoscope-paper_month"><?=HDate::ruMonthShort(date("n", strtotime($model->date)))?></div>
            </div>
        <?php elseif ($type == 'month'): ?>
               <div class="horoscope-paper">
                   <div class="horoscope-paper_date"><?=HDate::ruMonthShort($model->month)?></div>
                   <div class="horoscope-paper_month"><?=$model->year?></div>
               </div>
        <?php endif; ?>
        <?php if ($type == 'year'): ?>
        <p class="lineheight-big">
            <p><strong>Здоровье.</strong> <?=$model->health?></p>
            <p><strong>Карьера.</strong> <?=$model->career?></p>
            <p><strong>Финансы.</strong> <?=$model->finance?></p>
            <p><strong>Личная жизнь.</strong> <?=$model->personal?></p>
        </p>
        <?php else: ?>
        <p class="lineheight-big"><?=Str::strToParagraph($model->text)?></p>
        <?php endif; ?>
    </div>

    <div class="margin-b10">
				<span class="color-lilac">
				&larr;  <a href="<?=$this->createUrl('/horoscope/index')?>" class="color-lilac text-small">Гороскоп все знаки</a>
				</span>
    </div>

</div>