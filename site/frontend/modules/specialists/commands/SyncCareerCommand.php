<?php

namespace site\frontend\modules\specialists\commands;

use site\frontend\modules\specialists\models\SpecialistProfile;
use site\frontend\modules\specialists\models\SpecialistsCareer;

/**
 * CareerSyncCommand class
 *
 * Синхронизация данных карьеры специалистов в новую таблицу specialists__profile_career
 *
 * @author Sergey Gubarev
 */
class SyncCareerCommand extends \CConsoleCommand
{

    public $processed = 0;

    public $sync = 0;

    public function actionIndex()
    {
        $profileModel = new SpecialistProfile();

        $allCount = $profileModel->count();
        $profiles = $profileModel->findAll();

        echo "\033[37;1;44m Синхронизация " . $profileModel->tableName() . " -> " . (new SpecialistsCareer())->tableName() . " \033[0m" . PHP_EOL;

        try
        {
            foreach ($profiles as $profile)
            {
                if ($careerArr = \CJSON::decode($profile->career))
                {
                    foreach ($careerArr as $data) {
                        $years = $data['years'];
                        $place = $data['place'];

                        $yearsArr = explode('-', $years);

                        $profileCareerModel = new SpecialistsCareer();
                        $profileCareerModel->profile_id = $profile->id;
                        $profileCareerModel->place = trim($place);
                        $profileCareerModel->start_year = trim($yearsArr[0]);
                        $profileCareerModel->end_year = trim($yearsArr[1]);
                        $profileCareerModel->save();

                        $this->sync++;
                    }
                }

                $this->processed++;

                echo "\033[30;1;47m Обработано: " . $this->processed . " из " . $allCount . " \033[0m";
                usleep(10000);

                if ($this->processed != $allCount) echo "\033[40D";
            }

            echo PHP_EOL . "\033[37;1;42m Завершено \033[0m";
            echo PHP_EOL . "\033[30;1;47m Синхронизированно: " . $this->sync . " \033[0m" . PHP_EOL;
        }
        catch (\CDbException $e)
        {
            echo "\033[37;1;41m Ошибка \033[0m" . PHP_EOL . $e->getMessage();
            return 1;
        }
    }

}