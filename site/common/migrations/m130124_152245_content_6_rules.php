<?php

class m130124_152245_content_6_rules extends CDbMigration
{
	public function up()
	{
        $sql = <<<EOD
<h4>1. Сроки проведения фотоконкурса «Кроха кушает»</h4>

<p>1.1. Фотоконкурс «Кроха кушает» будет проведен с 10.01.2013 по 23.01.2013 г. на сайте <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a>.</p>

<h4>2. Условия участия</h4>

<p>2.1. Участник Конкурса должен проживать на территории России, Украины, Белоруси или Казахстана.</p>
<p>2.2. Все участники Конкурса должны пройти 6 шагов заполнения анкеты.</p>
<p>2.3. На конкурсном фото должен быть изображен ваш ребенок.</p>
<p>2.4. От одного пользователя принимается одно фото.</p>
<p>2.5. Фото должно быть хорошего качества.</p>

<h4>3. Голосование и подведение итогов Конкурса</h4>

<p>3.1. Победители Конкурса определяются следующим механизмом: победители будут определены экспертным жюри из числа первых ста участников, набравших наибольшее количество голосов пользователей сайта <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a>.</p>
<p>3.2. Голосование предполагает возможность зарегистрированного или авторизованного через свою учетную запись социальной сети (“Facebook”, “ВКонтакте”, “Одноклассники”, “Twitter”) посетителя сайта <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a> отдать свой голос за наиболее понравившееся фото, участвующее в Конкурсе.</p>
<p>3.3. При возникновении ситуации, когда обе фотографии набирают равное количество голосов, победителем выбирается тот, кто опубликовал фото раньше.</p>
<p>3.4. Итоги Конкурса будут подведены 30.01.2013 г.</p>

<h4>4. Права и обязанности Участников Конкурса</h4>

<p>4.1. Для участия в Конкурсе необходимо быть зарегистрированным пользователем сайта <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a>, пройти 6 шагов заполнения анкеты. Затем Участник может опубликовать конкурсную фотографию. Фотография должна соответствовать теме и условиям Конкурса.</p>
<p>4.2. Пользователь может разместить только одну фотографию на Конкурс.</p>
<p>4.3. Фотография должна быть хорошего качества.</p>
<p>4.4. Фотография должна иметь название.</p>
<p>4.5. Участником Конкурса может стать любой пользователь, достигший 18 лет.</p>
<p>4.6. К участию в Конкурсе не допускаются:</p>
<ul>
    <li>- сотрудники и представители Организатора;</li>
    <li>- лица, способные повлиять на их деятельность;</li>
    <li>- члены их семей;</li>
    <li>- работники других юридических лиц, причастных к организации и проведению Конкурса.</li>
</ul>
<p>4.7. Участники Конкурса при регистрации на сайте и публикации фотографии на странице Конкурса тем самым дают свое согласие на то, что загруженные ими фотографии будут публично показаны и обсуждены с целью их оценки</p>
<p>4.8. Участники гарантируют, что конкурсные фотографии не нарушают и не будут нарушать права интеллектуальной собственности третьих лиц</p>
<p>4.9. В случае нарушения этого требования Участники обязуются возместить организатору все понесенные убытки, в том числе все судебные расходы и расходы, понесенные в связи с защитой организатором своих прав.</p>
<p>4.10. К участию в Конкурсе не допускаются:</p>
<ul>
    <li>- фотографии, содержание которых не соответствует теме Конкурса;</li>
    <li>- фотографии, содержание которых противоречит законодательству РФ;</li>
    <li>- изображения эротического или оскорбительного содержания;</li>
    <li>- изображения, прямо или косвенно рекламирующие какие-либо товары и услуги.</li>
</ul>
<p>4.11. Фотографии, не соответствующие указанным в Правилах критериям, будут удаляться администрацией без объяснения причин.</p>
<p>4.12. При выявлении факта накрутки баллов при голосовании фотография снимается с Конкурса.</p>

<h4>5. Наградной фонд</h4>

<p>5.1. Наградной фонд Конкурса формируется за счет средств Организатора Конкурса.</p>
<p>5.2. Победители Конкурса в зависимости от занятого места получают следующие призы:</p>
<ul>
    <li>- 1 место - Детские электронные весы LAICA PS3003 (Италия) <br></li>
    <li>- 2 место - Мини-блендер Philips AVENT SCF 860/22 <br></li>
    <li>- 3 место - Мини-комбайн Maman ЕС01М <br></li>
</ul>
<p>5.3. Денежный эквивалент приза не выплачивается. Призы возврату, обмену и передаче другим лицам не подлежат.</p>

<h4>6. Порядок проведения Конкурса</h4>

<p>6.1. Все участники Конкурса размещают фотографии на странице Конкурса на сайте <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a>.</p>
<p>6.2. Победителями станут 3 (три) Участника, победителей выберет экспертное жюри из первых ста участников, набравших наибольшее количество голосов пользователей  сайта  <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a>.</p>
<p>6.3. Голосование предполагает возможность зарегистрированного или авторизованного через свою учетную запись в социальной сети посетителя сайта <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a> отдать свой голос за наиболее понравившееся фото, участвующее в фотоконкурсе.</p>
<p>6.4. Информация о победителях будет опубликована на сайте 30.01.2013 г.</p>
<p>6.5. Организаторы направят в адрес Участников-победителей информационное письмо.</p>
<p>6.6. Доставка призов Конкурса будет осуществляться курьерской службой или почтой России.</p>
<p>6.7. Организатор не несет ответственности за неполучение приза победителем в случае невозможности связаться с ним по указанным им контактам (телефон абонента отключен, находится вне зоны обслуживания, услуги Интернета не оплачены и т.п.) или предоставления контактных данных позднее, чем через 3 недели после объявления результатов фотоконкурса.</p>

<h4>7. Иные условия проведения Конкурса</h4>

<p>7.1. Организатор Конкурса гарантирует неразглашение информации о номерах телефонов Участников и других их данных, ставших известными ему в ходе проведения Конкурса.</p>
<p>7.2. Организатор Конкурса гарантирует использование полученных им данных Участников только по прямому назначению, в соответствии с правилами проведения Конкурса.</p>
EOD;
        $this->execute('UPDATE contest__contests SET rules = \''.$sql.'\' WHERE id = 6;');
	}

	public function down()
	{
		echo "m130124_152245_content_6_rules does not support migration down.\n";
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