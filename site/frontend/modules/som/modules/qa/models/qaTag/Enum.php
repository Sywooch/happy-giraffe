<?php

namespace site\frontend\modules\som\modules\qa\models\qaTag;

/**
 *
 * @author Emil Vililyaev
 */
class Enum
{

    /**
     *
     * @var string
     */
    const LESS_THAN_YEAR    = '0-1';

    /**
     *
     * @var string
     */
    const MORE_THAN_YEAR    = '1-3';

    /**
     *
     * @var string
     */
    const PRESCHOOL         = '3-6';

    /**
     *
     * @var string
     */
    const SCHOOLKID         = '6-12';

    //-----------------------------------------------------------------------------------------------------------

    /**
     *
     * @var array
     */
    private $_titlesForWeb = [
        self::LESS_THAN_YEAR    => '0 - 1',
        self::MORE_THAN_YEAR    => '1 - 3',
        self::PRESCHOOL         => '3 - 6',
        self::SCHOOLKID         => '6 - 12',
    ];

    /**
     *
     * @var array
     */
    private $_titlesForMobileApi = [
        self::LESS_THAN_YEAR    => 'Дети до года',
        self::MORE_THAN_YEAR    => 'Дети старше года',
        self::PRESCHOOL         => 'Дошкольники',
        self::SCHOOLKID         => 'Школьники',
    ];

    //-----------------------------------------------------------------------------------------------------------

    /**
     * @param array $arrTitle
     * @param mixed $value
     * @param boolean $throwException
     * @throws \CException
     * @return NULL|string
     */
    private function _getTitle($arrTitle, $value, $throwException = FALSE)
    {
        if (!is_array($arrTitle) || !array_key_exists($value, $arrTitle))
        {
            if ($throwException)
            {
                throw new \CException('Tag value not valid!');
            }

            return NULL;
        }

        return $arrTitle[$value];
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * @param mixed $value
     * @return NULL|string
     */
    public function getTitleForWeb($value, $validate = FALSE)
    {
        return $this->_getTitle($this->_titlesForWeb, $value, $validate);
    }

    /**
     * @param mixed $value
     * @return NULL|string
     */
    public function getTitleForMobileApi($value, $validate = FALSE)
    {
        return $this->_getTitle($this->_titlesForMobileApi, $value, $validate);
    }
}
