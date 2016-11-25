<?php

/**
 * @author Emil Vililyaev
 */
class DBTestCommand extends CConsoleCommand
{

    private $_startTime;

    private $_maxInsertDifference;
    private $_maxReadDifference;

    public function actionRun()
    {
        $this->_createTable();

        $this->_replication();

        $this->_deleteTable();
    }

    private function _createTable()
    {
        echo "------------------------\n";
        echo "create table: db_test \n";

        $this->_printStartTime();

        $sql = '
            CREATE TABLE `db_test` (
    	        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    	        `data1` int(11) unsigned NOT NULL,
    	        `data2` varchar(10) NOT NULL,
    	        `data3` tinyint(3) unsigned NOT NULL,
    	        `data4` timestamp NOT NULL,
    	        PRIMARY KEY (`id`),
    	        KEY `data1` (`data1`),
    	        KEY `data2` (`data2`),
    	        KEY `data3` (`data3`),
    	        KEY `data4` (`data4`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

        \Yii::app()->db->createCommand($sql)->execute();

        $this->_printEndTime();
        echo "table created! \n";
        echo "------------------------\n\n";
    }

    private function _deleteTable()
    {
        echo "------------------------\n";
        echo "delete table: db_test \n";

        $this->_printStartTime();

        $sql = 'DROP TABLE IF EXISTS db_test;';

        \Yii::app()->db->createCommand($sql)->execute();

        $this->_printEndTime();
        echo "table deleted! \n";
        echo "------------------------\n\n";
    }

    private function _replication($checkRow = true)
    {
        $db = \Yii::app()->db;

        echo "------------------------\n";
        echo "insert data: db_test \n";
        $this->_printStartTime();

        for ($i=0; $i<10000; $i++)
        {
            $sql = "INSERT INTO `db_test` (`data1`, `data2`, `data3`, `data4`) VALUES ($i, 'row_$i', 1, '" . date('Y-m-d H:i:s') . "');";

            $insertStartTime = round(microtime(true) * 1000, 3);

            $db->createCommand($sql)->execute();

            $insertEndTime = round(microtime(true) * 1000, 3);
            $difference = round($insertEndTime - $insertStartTime, 3);

            if ($this->_maxInsertDifference < $difference)
            {
                $this->_maxInsertDifference = $difference;
            }

            echo "\033[17D";
            echo str_pad($i, 4, ' ', STR_PAD_LEFT) . " row inserted";

            if ($checkRow)
            {
                $sql = "SELECT * FROM `db_test` WHERE `data1`=$i;";

                $readStartTime = round(microtime(true) * 1000, 3);

                $result = $db->createCommand($sql)->execute();

                $readEndTime = round(microtime(true) * 1000, 3);
                $differenceRead = round($readEndTime - $readStartTime, 3);

                if ($this->_maxReadDifference < $differenceRead)
                {
                    $this->_maxReadDifference = $differenceRead;
                }

                if ($result)
                {
                    echo " and checked";
                    echo "\033[12D";
                } else {
                    echo " and checked FAIL!\n";
                    echo "Aborting!\n";
                    break;
                }
            }
        }

        echo "\n";
        $this->_printEndTime();
        echo "insert complete! \n";
        echo "Max insert time: " . $this->_maxInsertDifference . " ms\n";
        echo "Max read time: " . $this->_maxReadDifference . " ms \n";
        echo "------------------------\n\n";
    }

    private function _printStartTime()
    {
        $this->_startTime = round(microtime(true) * 1000, 3);
//         echo 'Start time:' . $this->_startTime . "\n";
    }

    private function _printEndTime()
    {
        $endTime = round(microtime(true) * 1000, 3);
//         echo 'End time:' . $endTime . "\n";
        echo 'Difference: ', round($endTime - $this->_startTime, 3) . " ms\n";
        $this->_startTime = 0;
    }

}