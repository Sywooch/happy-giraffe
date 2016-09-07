<?php

class m140828_054703_calendar_update extends CDbMigration
{

    public function up()
    {
        $this->execute("
UPDATE `calendar__periods` SET `title`='1 нед.' WHERE `id`='2';
UPDATE `calendar__periods` SET `title`='2 нед.' WHERE `id`='3';
UPDATE `calendar__periods` SET `title`='3 нед.' WHERE `id`='4';
UPDATE `calendar__periods` SET `title`='4 нед.' WHERE `id`='5';
UPDATE `calendar__periods` SET `title`='2 мес.' WHERE `id`='6';
UPDATE `calendar__periods` SET `title`='3 мес.' WHERE `id`='7';
UPDATE `calendar__periods` SET `title`='4 мес.' WHERE `id`='8';
UPDATE `calendar__periods` SET `title`='5 мес.' WHERE `id`='9';
UPDATE `calendar__periods` SET `title`='6 мес.' WHERE `id`='10';
UPDATE `calendar__periods` SET `title`='7 мес.' WHERE `id`='11';
UPDATE `calendar__periods` SET `title`='8 мес.' WHERE `id`='12';
UPDATE `calendar__periods` SET `title`='9 мес.' WHERE `id`='13';
UPDATE `calendar__periods` SET `title`='10 мес.' WHERE `id`='14';
UPDATE `calendar__periods` SET `title`='11 мес.' WHERE `id`='15';
UPDATE `calendar__periods` SET `title`='12 мес.' WHERE `id`='16';
UPDATE `calendar__periods` SET `title`='12-15 мес.' WHERE `id`='17';
UPDATE `calendar__periods` SET `title`='15-18 мес.' WHERE `id`='18';
UPDATE `calendar__periods` SET `title`='18-21 мес.' WHERE `id`='19';
UPDATE `calendar__periods` SET `title`='1 неделя' WHERE `id`='28';
UPDATE `calendar__periods` SET `title`='2 неделя' WHERE `id`='29';
UPDATE `calendar__periods` SET `title`='3 неделя' WHERE `id`='30';
UPDATE `calendar__periods` SET `title`='4 неделя' WHERE `id`='31';
UPDATE `calendar__periods` SET `title`='5 неделя' WHERE `id`='32';
UPDATE `calendar__periods` SET `title`='6 неделя' WHERE `id`='33';
UPDATE `calendar__periods` SET `title`='7 неделя' WHERE `id`='34';
UPDATE `calendar__periods` SET `title`='8 неделя' WHERE `id`='35';
UPDATE `calendar__periods` SET `title`='9 неделя' WHERE `id`='36';
UPDATE `calendar__periods` SET `title`='10 неделя' WHERE `id`='37';
UPDATE `calendar__periods` SET `title`='11 неделя' WHERE `id`='38';
UPDATE `calendar__periods` SET `title`='12 неделя' WHERE `id`='39';
UPDATE `calendar__periods` SET `title`='13 неделя' WHERE `id`='40';
UPDATE `calendar__periods` SET `title`='14 неделя' WHERE `id`='41';
UPDATE `calendar__periods` SET `title`='15 неделя' WHERE `id`='42';
UPDATE `calendar__periods` SET `title`='16 неделя' WHERE `id`='43';
UPDATE `calendar__periods` SET `title`='17 неделя' WHERE `id`='44';
UPDATE `calendar__periods` SET `title`='18 неделя' WHERE `id`='45';
UPDATE `calendar__periods` SET `title`='19 неделя' WHERE `id`='46';
UPDATE `calendar__periods` SET `title`='20 неделя' WHERE `id`='47';
UPDATE `calendar__periods` SET `title`='21 неделя' WHERE `id`='48';
UPDATE `calendar__periods` SET `title`='22 неделя' WHERE `id`='49';
UPDATE `calendar__periods` SET `title`='23 неделя' WHERE `id`='50';
UPDATE `calendar__periods` SET `title`='24 неделя' WHERE `id`='51';
UPDATE `calendar__periods` SET `title`='25 неделя' WHERE `id`='52';
UPDATE `calendar__periods` SET `title`='26 неделя' WHERE `id`='53';
UPDATE `calendar__periods` SET `title`='27 неделя' WHERE `id`='54';
UPDATE `calendar__periods` SET `title`='28 неделя' WHERE `id`='55';
UPDATE `calendar__periods` SET `title`='29 неделя' WHERE `id`='56';
UPDATE `calendar__periods` SET `title`='30 неделя' WHERE `id`='57';
UPDATE `calendar__periods` SET `title`='31 неделя' WHERE `id`='58';
UPDATE `calendar__periods` SET `title`='32 неделя' WHERE `id`='59';
UPDATE `calendar__periods` SET `title`='33 неделя' WHERE `id`='60';
UPDATE `calendar__periods` SET `title`='34 неделя' WHERE `id`='61';
UPDATE `calendar__periods` SET `title`='35 неделя' WHERE `id`='62';
UPDATE `calendar__periods` SET `title`='36 неделя' WHERE `id`='63';
UPDATE `calendar__periods` SET `title`='37 неделя' WHERE `id`='64';
UPDATE `calendar__periods` SET `title`='38 неделя' WHERE `id`='65';
UPDATE `calendar__periods` SET `title`='39 неделя' WHERE `id`='66';
UPDATE `calendar__periods` SET `title`='40 неделя' WHERE `id`='67';
UPDATE `calendar__periods` SET `title`='3-7 лет' WHERE `id`='23';
UPDATE `calendar__periods` SET `title`='7-11 лет' WHERE `id`='24';
UPDATE `calendar__periods` SET `title`='11-14 лет' WHERE `id`='25';
UPDATE `calendar__periods` SET `title`='14-18 лет' WHERE `id`='26';
UPDATE `calendar__periods` SET `title`='2.5-3 года' WHERE `id`='22';
UPDATE `calendar__periods` SET `title`='2-2.5 года' WHERE `id`='21';
UPDATE `calendar__periods` SET `title`='21-24 мес.' WHERE `id`='20';
");
    }

    public function down()
    {
        echo "m140828_054703_calendar_update does not support migration down.\n";
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