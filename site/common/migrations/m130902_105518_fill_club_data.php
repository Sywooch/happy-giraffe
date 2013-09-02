<?php

class m130902_105518_fill_club_data extends CDbMigration
{
    private $_table = '';

    public function up()
    {
        $this->execute("INSERT INTO `community__sections` (`id`, `title`) VALUES
(1, 'Беременность и дети'),
(2, 'Наш дом'),
(3, 'Красота и здоровье'),
(4, 'Мужчина и женщина'),
(5, 'Интересы и увлечения'),
(6, 'Отдых');

INSERT INTO `community__clubs` (`id`, `title`, `description`, `section_id`) VALUES
(1, 'Планирование', NULL, 1),
(2, 'Беременность и роды', NULL, 1),
(3, 'Дети до года', NULL, 1),
(4, 'Дети старше года', NULL, 1),
(5, 'Дошкольники', NULL, 1),
(6, 'Школьники', NULL, 1),
(7, 'Готовим на кухне', NULL, 2),
(8, 'Ремонт в доме', NULL, 2),
(9, 'Домашние хлопоты', NULL, 2),
(10, 'Сад и огород', NULL, 2),
(11, 'Наши питомцы', NULL, 2),
(12, 'Красота и мода', NULL, 3),
(13, 'Наше здоровье', NULL, 3),
(14, 'Свадьба', NULL, 4),
(15, 'Отношения в семье', NULL, 4),
(16, 'Рукоделие', NULL, 5),
(17, 'Цветы в доме', NULL, 5),
(18, 'Наш автомобиль', NULL, 5),
(19, 'Рыбалка', NULL, 5),
(20, 'Мы путешествуем', NULL, 6),
(21, 'Выходные с семьей', NULL, 6),
(22, 'Праздники', NULL, 6);
");
        try{
            $this->insert('community__forums', array(
                'id'=>38,
                'title'=>'Образование',
            ));
            $this->insert('community__forums', array(
                'id'=>39,
                'title'=>'Наши питомцы',
            ));
            $this->insert('community__forums', array(
                'id'=>40,
                'title'=>'Спорт',
            ));
            $this->insert('community__forums', array(
                'id'=>41,
                'title'=>'Рыбалка и охота',
            ));

        }catch (Exception $e){

        }

        $this->update('community__forums', array('club_id' => 1), 'id=1');
        $this->update('community__forums', array('club_id' => 2), 'id=2');
        $this->update('community__forums', array('club_id' => 2), 'id=3');

        $this->update('community__forums', array('club_id' => 3), 'id=4');
        $this->update('community__forums', array('club_id' => 3), 'id=5');
        $this->update('community__forums', array('club_id' => 3), 'id=6');
        $this->update('community__forums', array('club_id' => 3), 'id=7');

        $this->update('community__forums', array('club_id' => 4), 'id=8');
        $this->update('community__forums', array('club_id' => 4), 'id=9');
        $this->update('community__forums', array('club_id' => 4), 'id=10');
        $this->update('community__forums', array('club_id' => 4), 'id=11');

        $this->update('community__forums', array('club_id' => 5), 'id=12');
        $this->update('community__forums', array('club_id' => 5), 'id=13');
        $this->update('community__forums', array('club_id' => 5), 'id=14');

        $this->update('community__forums', array('club_id' => 6), 'id=15');
        $this->update('community__forums', array('club_id' => 6), 'id=16');
        $this->update('community__forums', array('club_id' => 6), 'id=17');
        $this->update('community__forums', array('club_id' => 6), 'id=18');

        $this->update('community__forums', array('club_id' => 7), 'id=22');
        $this->update('community__forums', array('club_id' => 7), 'id=23');

        $this->update('community__forums', array('club_id' => 8), 'id=26');
        $this->update('community__forums', array('club_id' => 9), 'id=28');
        $this->update('community__forums', array('club_id' => 10), 'id=34');
        $this->update('community__forums', array('club_id' => 11), 'id=39');

        $this->update('community__forums', array('club_id' => 12), 'id=29');
        $this->update('community__forums', array('club_id' => 12), 'id=30');

        $this->update('community__forums', array('club_id' => 13), 'id=33');
        $this->update('community__forums', array('club_id' => 14), 'id=32');
        $this->update('community__forums', array('club_id' => 15), 'id=31');

        $this->update('community__forums', array('club_id' => 16), 'id=24');
        $this->update('community__forums', array('club_id' => 16), 'id=25');

        $this->update('community__forums', array('club_id' => 17), 'id=35');
        $this->update('community__forums', array('club_id' => 18), 'id=27');
        $this->update('community__forums', array('club_id' => 19), 'id=41');
        $this->update('community__forums', array('club_id' => 20), 'id=21');
        $this->update('community__forums', array('club_id' => 20), 'id=19');
        $this->update('community__forums', array('club_id' => 20), 'id=20');
    }

    public function down()
    {
        echo "m130902_105518_fill_club_data does not support migration down.\n";
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