<?php

class m121107_090533_contest_rules extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `contest__contests` ADD  `rules` TEXT NOT NULL AFTER  `text`");
        $this->execute('UPDATE `happy_giraffe`.`contest__contests` SET `rules` = \'    <h4>1. Сроки проведения фотоконкурса “Мама и я”</h4>

    <p>1.1. Фотоконкурс “Мама и я” будет проведен с 15.10.2012 по 5.11.2012 г. на сайте <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a>.</p>

    <h4>2. Условия участия</h4>

    <p>2.1. Участник Конкурса должен проживать на территории России, Украины, Белоруси или Казахстана.</p>
    <p>2.2. Все участники Конкурса должны пройти 6 шагов заполнения анкеты.</p>
    <p>2.3. На конкурсном фото должны быть изображены мама и ее ребенок.</p>

    <p>2.4. От одного пользователя принимается одно фото.</p>

    <p>2.5. Фото должно быть хорошего качества.</p>

    <h4>3. Голосование и подведение итогов Конкурса</h4>

    <p>3.1. Победители Конкурса определяются общим голосованием пользователей.</p>

    <p>3.2. Голосование предполагает возможность зарегистрированного или авторизованного через свою учетную запись социальной сети (“Facebook”, “ВКонтакте”, “Одноклассники”, “Twitter”) посетителя сайта <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a> отдать свой голос за наиболее понравившееся фото, участвующее в Конкурсе.</p>

    <p>3.3. При возникновении ситуации, когда обе фотографии набирают равное количество голосов, победителем выбирается тот, кто опубликовал фото раньше.</p>

    <p>3.4. Итоги Конкурса будут подведены 12.11.2012 г.</p>

    <h4>4. Права и обязанности Участников Конкурса</h4>

    <p>4.1. Для участия в Конкурсе необходимо быть зарегистрированным пользователем сайта <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a>, пройти 6 шагов заполнения анкеты. Затем Участник может опубликовать конкурсную фотографию. Фотография должна соответствовать теме и условиям Конкурса.</p>

    <p>4.2. Пользователь может разместить только одну фотографию на Конкурс.</p>

    <p>4.3. Фотография должна быть хорошего качества.</p>

    <p>4.4. Фотография должна иметь название.</p>

    <p>4.5. Участником Конкурса может стать любой пользователь, достигший 18 лет.</p>

    <p>4.6. К участию в Конкурсе не допускаются:</p>

    <ul>
        <li>сотрудники и представители Организатора;</li>

        <li>лица, способные повлиять на их деятельность;</li>

        <li>члены их семей;</li>

        <li>работники других юридических лиц, причастных к организации и проведению Конкурса.</li>
    </ul>

    <p>4.7. Участники Конкурса при регистрации на сайте и публикации фотографии на странице Конкурса тем самым дают свое согласие на то, что загруженные ими фотографии будут публично показаны и обсуждены с целью их оценки.</p>

    <p>4.8. Участники гарантируют, что конкурсные фотографии не нарушают и не будут нарушать права интеллектуальной собственности третьих лиц.</p>

    <p>4.9. В случае нарушения этого требования Участники обязуются возместить организатору все понесенные убытки, в том числе все судебные расходы и расходы, понесенные в связи с защитой организатором своих прав.</p>

    <p>4.10. К участию в Конкурсе не допускаются:</p>

    <ul>
        <li>фотографии, содержание которых не соответствует теме Конкурса;</li>
        <li>фотографии, содержание которых противоречит законодательству РФ;</li>
        <li>изображения эротического или оскорбительного содержания;</li>
        <li>изображения, прямо или косвенно рекламирующие какие-либо товары и услуги.</li>
    </ul>

    <p>4.11. Фотографии, не соответствующие указанным в Правилах критериям, будут удаляться администрацией без объяснения причин.</p>

    <p>4.12. При выявлении факта накрутки баллов при голосовании фотография снимается с Конкурса.</p>

    <h4>5. Наградной фонд</h4>

    <p>5.1. Наградной фонд Конкурса формируется за счет средств Организатора Конкурса.</p>

    <p>5.2. Победители Конкурса в зависимости от занятого места получают следующие призы:</p>

    <ul>
        <li>1 место – Фотоаппарат SONY Cyber-shot DSC-HX10 <br></li>
        <li>2 место – Фоторамка 8" SONY DPF-D830LB <br></li>
        <li>3 место – Фоторамка 8" SONY DPF-D830LB <br></li>
    </ul>

    <p>5.3. Денежный эквивалент приза не выплачивается. Призы возврату, обмену и передаче другим лицам не подлежат.</p>

    <h4>6. Порядок проведения Конкурса</h4>

    <p>6.1. Все участники Конкурса размещают фотографии на странице Конкурса на сайте <a href="#">http://www.happy-giraffe.ru</a>.</p>

    <p>6.2. Победителями станут 3 (три) Участника, решение о победителях принимает экспертное жюри по результатам голосования зарегистрированных пользователей сайта <a href="#">http://www.happy-giraffe.ru</a>.</p>

    <p>6.3.Голосование предполагает возможность зарегистрированного или авторизованного через свою учетную запись в социальной сети посетителя сайта <a href="#">http://www.happy-giraffe.ru</a> отдать свой голос за наиболее понравившееся фото, участвующее в фотоконкурсе.</p>

    <p>6.4. Информация о победителях будет опубликована на сайте 12.11.2012 г.</p>

    <p>6.5. Организаторы направят в адрес Участников-победителей информационное письмо.</p>

    <p>6.6. Доставка призов Конкурса будет осуществляться курьерской службой или почтой России.</p>

    <p>6.7. Организатор не несет ответственности за неполучение приза победителем в случае невозможности связаться с ним по указанным им контактам (телефон абонента отключен, находится вне зоны обслуживания, услуги Интернета не оплачены и т.п.) или предоставления контактных данных позднее, чем через 3 недели после объявления результатов фотоконкурса.</p>

    <h4>7. Иные условия проведения Конкурса</h4>

    <p>7.1. Организатор Конкурса гарантирует неразглашение информации о номерах телефонов Участников и других их данных, ставших известными ему в ходе проведения Конкурса.</p>

    <p>7.2. Организатор Конкурса гарантирует использование полученных им данных Участников только по прямому назначению, в соответствии с правилами проведения Конкурса.</p>\' WHERE `contest__contests`.`id` = 2;');
	    $this->execute('UPDATE `happy_giraffe`.`contest__contests` SET `rules` = \'<h4>1. Сроки проведения конкурса “Веселая семейка”</h4>
    <p>1.1. Фотоконкурс “Веселая семейка” проводится с 21.03.2012 по 20.04.2012 г. на сайте <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a>.</p>

    <h4>2. Условия участия</h4>
    <p>2.1. Для участия в фотоконкурсе необходимо заполнить свой профиль и написать необходимую информацию о членах своей семьи.</p>
    <p>2.2. От одного пользователя принимается одно фото.</p>
    <p>2.3. Фото должно быть хорошего качества и соответствовать теме фотоконкурса.</p>

    <h4>3. Голосование и подведение итогов фотоконкурса</h4>
    <p>3.1. Победители конкурса определяются общим голосованием пользователей.</p>
    <p>3.2. Голосование предполагает возможность зарегистрированного или авторизованного через свою учетную запись в социальной сети посетителя сайта <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a> отдать свой голос за наиболее понравившееся фото, участвующее в фотоконкурсе.</p>
    <p>3.3. Итоги конкурса будут подведены 30.04.2012г.</p>

    <h4>4. Права и обязанности участников конкурса</h4>
    <p>4.1. Для участия в конкурсе необходимо зарегистрироваться на сайте <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a>, заполнить в профиле личные данные и данные о своей семье, опубликовать фотографию на странице фотоконкурса. Фотография должна соответствовать теме и условиям конкурса.</p>
    <p>4.2. Пользователь может разместить только одну фотографию на фотоконкурс.</p>
    <p>4.3. Фотография должна быть хорошего качества.</p>
    <p>4.4. Участником конкурса (далее – «Участник») может стать любой пользователь, достигший 18 лет.</p>
    <p class="rules-list">4.5. К участию в фотоконкурсе не допускаются:<br/>
        – сотрудники и представители Организатора;<br/>
        – лица, способные повлиять на их деятельность;<br/>
        – члены их семей;<br/>
        – работники других юридических лиц, причастных к организации и проведению конкурса.</p>
    <p>4.6. Участники конкурса при регистрации на сайте и публикации фотографии на странице фотоконкурса тем самым дают свое согласие на то, что загруженные ими фотографии будут публично показаны и обсуждены с целью их оценки.</p>
    <p>4.7. Участники гарантируют, что конкурсные фотографии не нарушают и не будут нарушать права интеллектуальной собственности третьих лиц.</p>
    <p>4.8. В случае нарушения этого требования Участники обязуются возместить Организатору все понесенные убытки, в том числе все судебные расходы и расходы, понесенные в связи с защитой Организатором своих прав.</p>
    <p class="rules-list">4.9. К участию в фотоконкурсе не допускаются:<br/>
        – фотографии, содержание которых не соответствует теме фотоконкурса;<br/>
        – фотографии, содержание которых противоречит законодательству РФ;<br/>
        – изображения эротического или оскорбительного содержания;<br/>
        – изображения, прямо или косвенно рекламирующие какие-либо товары и услуги.</p>
    <p>4.10. Фотографии, не соответствующие указанным в Правилах критериям, будут удаляться администрацией без объяснения причин.</p>
    <p>4.11. При выявлении факта накрутки баллов при голосовании фотография снимается с фотоконкурса.</p>

    <h4>5. Наградной фонд</h4>
    <p>5.1. Наградной фонд фотоконкурса формируется за счет средств Организатора Конкурса.</p>
    <p class="rules-list">5.2. Победители фотоконкурса в зависимости от занятого места получают следующие призы:<br/>
        1 место – мультиварка Land Life YBW60-100A1<br/>
        2 место – мультиварка BRAND 37501<br/>
        3 место – мультиварка Land Life YBD60-100A<br/>
        4 место – мультиварка Polaris PMC 0506AD<br/>
        5 место – мультиварка SUPRA MCS-4501</p>
    <p>5.3. Денежный эквивалент приза не выплачивается. Призы возврату, обмену и передаче другим лицам не подлежат.</p>

    <h4>6. Порядок проведения конкурса</h4>
    <p>6.1. Все участники фотоконкурса “Веселая семейка” размещают фотографии на странице фотоконкурса на сайте <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a>.</p>
    <p>6.2. Победителями станут 5 (пять) участников, решение о победителях принимает экспертное жюри по результатам голосования зарегистрированных пользователей сайта <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a>.</p>
    <p>6.3.Голосование предполагает возможность зарегистрированного или авторизованного через свою учетную запись в социальной сети посетителя сайта <a href="http://www.happy-giraffe.ru">http://www.happy-giraffe.ru</a> отдать свой голос за наиболее понравившееся фото, участвующее в фотоконкурсе.</p>
    <p>6.4. Информация о победителях будет опубликована на сайте 30.04.2012г.</p>
    <p>6.5. Доставка призов конкурса будет осуществляться курьерской службой и почтой России.</p>
    <p>6.6. Организатор не несет ответственности за неполучение приза победителем в случае невозможности связаться с ним по указанным им контактам (телефон абонента отключен, находится вне зоны обслуживания, услуги Интернета не оплачены и т.п.) или предоставлении контактных данных позднее, чем через 3 недели после объявления результатов фотоконкурса.</p>

    <h4>7. Иные условия проведения конкурса</h4>
    <p>7.1. Организатор конкурса гарантирует неразглашение информации о номерах телефонов Участников и других их данных, ставших известными ему в ходе проведения фотоконкурса.</p>
    <p>7.2. Организатор конкурса гарантирует использование полученных им данных участников только по прямому назначению, в соответствии с правилами проведения конкурса.</p>\' WHERE `contest__contests`.`id` = 1;');
    }

	public function down()
	{
		echo "m121107_090533_contest_rules does not support migration down.\n";
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