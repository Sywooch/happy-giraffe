<?php

namespace site\frontend\modules\geo2;

/**
 * @author Никита
 * @date 21/02/17
 */
class Geo2Module extends \CWebModule
{
    public static $fias = [
        'prefix' => 'FIAS__',
        'pks' => [
            'ACTSTAT' => 'ACTSTATID',
            'ADDROBJ' => 'AOID',
            'CENTERST' => 'CENTERSTID',
            'CURENTST' => 'CURENTSTID',
            'ESTSTAT' => 'ESTSTATID',
            'HOUSE' => 'HOUSEID',
            'HOUSEINT' => 'HOUSEINTID',
            'HSTSTAT' => 'HOUSESTID',
            'INTVSTAT' => 'INTVSTATID',
            'LANDMARK' => 'LANDID',
            'NDOCTYPE' => 'NDTYPEID',
            'NORMDOC' => 'NORMDOCID',
            'OPERSTAT' => 'OPERSTATID',
            'ROOM' => 'ROOMID',
            'SOCRBASE' => 'KOD_T_ST',
            'STEAD' => 'KOD_T_ST',
            'STRSTAT' => 'STRSTATID',
        ],
    ];

    public $controllerNamespace = 'site\frontend\modules\geo2\controllers';
}