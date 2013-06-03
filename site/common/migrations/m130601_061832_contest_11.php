<?php

class m130601_061832_contest_11 extends CDbMigration
{
	public function up()
	{
        $sql = <<<EOD
INSERT INTO `contest__contests` (`id`, `title`, `text`, `results_text`, `rules`, `from_time`, `till_time`, `status`, `last_updated`)
VALUES
	(11, 'Мы едем, едем, едем...', '<p>Летняя прогулка с ребенком всегда превращается в целое приключение. Маленькие сорванцы ни секунды не могут усидеть на месте, и постоянно чем-то заняты: катанием на самокатах, машинках, роликах.</p>\n<p>Пришлите нам фотографию своего ребенка с его любимым транспортным средством и получите один из трех отличных призов! </p>', '', '<h4>1. Общие правила проведения фотоконкурса «Мы едем, едем, едем...»</h4>\n\n<p>1.1. Фотоконкурс «Мы едем, едем, едем...» будет проведен с 3.06.2013 по 17.06.2013 г. на сайте <a href=\"http://www.happy-giraffe.ru\">http://www.happy-giraffe.ru</a>.</p>\n<p>1.2. Организаторами конкурса является <a href=\"http://www.happy-giraffe.ru\">http://www.happy-giraffe.ru</a> совместно с интенет-магазином Neopod.ru <a href=\"http://www.neopod.ru/\">http://www.neopod.ru/</a> и торговой маркой NeoTrike <a href=\"http://www.neopod.ru/brands/neotrike/\">http://www.neopod.ru/brands/neotrike/</a> </p>\n<p>1.3.  Участник Конкурса должен проживать на территории России, Украины, Белоруси или Казахстана.</p>\n<p>1.4. Все участники Конкурса должны пройти 6 шагов заполнения анкеты.</p>\n<p>1.5. На конкурсном фото должен быть изображен ребенок c детским транспортным средством. </p>\n<p>1.6. От одного пользователя принимается одно фото.</p>\n<p>1.7. Фото должно быть хорошего качества.</p>\n\n<h4>2. Голосование и подведение итогов Конкурса</h4>\n<p>2.1. Победители Конкурса определяются следующим механизмом: победители будут определены экспертным жюри из числа первых ста участников, набравших наибольшее количество голосов пользователей сайта <a href=\"http://www.happy-giraffe.ru\">http://www.happy-giraffe.ru</a></p>\n<p>2.2. Голосование предполагает возможность зарегистрированного или авторизованного через свою учетную запись социальной сети (“Facebook”, “ВКонтакте”, “Одноклассники”, “Twitter”) посетителя сайта <a href=\"http://www.happy-giraffe.ru\">http://www.happy-giraffe.ru</a> отдать свой голос за наиболее понравившееся фото, участвующее в Конкурсе.</p>\n<p>2.3. При возникновении ситуации, когда обе фотографии набирают равное количество голосов, победителем выбирается тот, кто опубликовал фото раньше.</p>\n<p>2.4. Итоги Конкурса будут подведены 24.06.2013 г.</p>\n\n<h4>3. Права и обязанности Участников Конкурса</h4>\n\n<p>3.1. Для участия в Конкурсе необходимо быть зарегистрированным пользователем сайта <a href=\"http://www.happy-giraffe.ru\">http://www.happy-giraffe.ru</a>, пройти 6 шагов заполнения анкеты. Затем Участник может опубликовать конкурсную фотографию. Фотография должна соответствовать теме и условиям Конкурса.</p>\n<p>3.2. Пользователь может разместить только одну фотографию на Конкурс.</p>\n<p>3.3. Фотография должна быть хорошего качества.</p>\n<p>3.4. Фотография должна иметь название.</p>\n<p>3.5. Участником Конкурса может стать любой пользователь, достигший 18 лет.</p>\n<p>3.6. К участию в Конкурсе не допускаются:</p>\n<ul>\n    <li>- сотрудники и представители Организаторов;</li>\n    <li>- лица, способные повлиять на их деятельность;</li>\n    <li>- члены их семей;</li>\n    <li>- работники других юридических лиц, причастных к организации и проведению Конкурса.</li>\n</ul>\n<p>3.7. Участники Конкурса при регистрации на сайте и публикации фотографии на странице Конкурса тем самым дают свое согласие на то, что загруженные ими фотографии будут публично показаны и обсуждены с целью их оценки.</p>\n<p>3.8. Участники гарантируют, что конкурсные фотографии не нарушают и не будут нарушать права интеллектуальной собственности третьих лиц.</p>\n<p>3.9. В случае нарушения этого требования Участники обязуются возместить организатору все понесенные убытки, в том числе все судебные расходы и расходы, понесенные в связи с защитой организатором своих прав.</p>\n<p>3.10. К участию в Конкурсе не допускаются:</p>\n<ul>\n    <li>- фотографии, содержание которых не соответствует теме Конкурса;</li>\n    <li>- фотографии, содержание которых противоречит законодательству РФ;</li>\n    <li>- изображения эротического или оскорбительного содержания;</li>\n    <li>- изображения, прямо или косвенно рекламирующие какие-либо товары и услуги.</li>\n</ul>\n<p>3.11. Фотографии, не соответствующие указанным в Правилах критериям, будут удаляться администрацией без объяснения причин.</p>\n<p>3.12. При выявлении факта накрутки баллов при голосовании фотография снимается с Конкурса.</p>\n\n<h4>4. Наградной фонд</h4>\n\n<p>4.1. Наградной фонд Конкурса формируется за счет средств Организатора Конкурса.</p>\n<p>4.2. Победители Конкурса получают следующие призы:</p>\n<ul>\n    <li>- 1 место - Детский электромобиль NeoTrike Beetle  <br></li>\n    <li>- 2 место - Детский электромобиль NeoTrike Mini Porsche  <br></li>\n    <li>- 3 место - Детский электромобиль NeoTrike Mini Mercedes Benz  <br></li>\n</ul>\n<p>4.3. Денежный эквивалент приза не выплачивается. Призы возврату, обмену и передаче другим лицам не подлежат.</p>\n\n<h4>5. Порядок проведения Конкурса</h4>\n\n<p>5.1. Все участники Конкурса размещают фотографии на странице Конкурса на сайте <a href=\"http://www.happy-giraffe.ru\">http://www.happy-giraffe.ru</a>.</p>\n<p>5.2. Победителями станут 3 (три) Участника, победителей выберет экспертное жюри из первых ста Участников, набравших наибольшее количество голосов пользователей сайта <a href=\"http://www.happy-giraffe.ru\">http://www.happy-giraffe.ru</a>.</p>\n<p>5.3. Голосование предполагает возможность зарегистрированного или авторизованного через свою учетную запись в социальной сети посетителя сайта <a href=\"http://www.happy-giraffe.ru\">http://www.happy-giraffe.ru</a> отдать свой голос за наиболее понравившееся фото, участвующее в фотоконкурсе.</p>\n<p>5.4. Информация о победителях будет опубликована на сайте 24.06.2013 г.</p>\n<p>5.5. Организаторы направят в адрес Участников-победителей информационное письмо.</p>\n<p>5.6. Доставка призов Конкурса будет осуществляться курьерской службой или почтой России.</p>\n<p>5.7. Организатор не несет ответственности за неполучение приза победителем в случае невозможности связаться с ним по указанным им контактам (телефон абонента отключен, находится вне зоны обслуживания, услуги Интернета не оплачены и т.п.) или предоставления контактных данных позднее, чем через 3 недели после объявления результатов фотоконкурса.</p>\n\n<h4>6. Иные условия проведения Конкурса</h4>\n\n<p>6.1. Организатор Конкурса гарантирует неразглашение информации о номерах телефонов Участников и других их данных, ставших известными ему в ходе проведения Конкурса.</p>\n<p>6.2. Организатор Конкурса гарантирует использование полученных им данных Участников только по прямому назначению, в соответствии с правилами проведения Конкурса.</p>', '2013-06-03', '2013-06-17', 1, NULL);

EOD;
        $this->execute($sql);
	}

	public function down()
	{
		echo "m130601_061832_contest_11 does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}