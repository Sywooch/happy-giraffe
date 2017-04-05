<?php

namespace site\frontend\components;

use site\frontend\components\api\models\User;

/**
 * @author Emil Vililyaev
 */
abstract class TopWidgetAbstract extends \CWidget
{

    /**
     * @var integer
     */
    private $_limit = 5;

    /**
     * @var string
     */
    private $_viewName;

    /**
     * Хранилище - собирает все данные (без PHP лимита)
     *
     * @var array
     */
    protected $scores = [];

    /**
     * @var integer
     */
    protected $_monthThreshold = 10;

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see CWidget::run()
     */
    public function run()
    {
        $data = $this->getData();

        if (!empty($data) && !is_null($this->_viewName))
        {
            $this->render($this->_viewName, $data);
        }
    }

    /**
     * {@inheritDoc}
     * @see CWidget::init()
     */
    public function init()
    {
        $this->_viewName = get_class($this);
    }

    /**
     * @param string $name
     */
    public function setViewName($name)
    {
        $this->_viewName = $name;
    }

    /**
     * @param integer $limit
     */
    public function setLimit($limit)
    {
        $this->_limit = $limit;
    }

    /**
     * @return integer
     */
    public function getLimit()
    {
        return $this->_limit;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $this->_process();

        $top = array_slice($this->scores, 0, $this->getLimit(), true);

        $users = User::model()->findAllByPk(array_keys($top), ['avatarSize' => 40]);

        $rows = [];
        foreach ($top as $uId => $score)
        {
            $rows[] = [
                'user' => $users[$uId],
                'score' => $score,
            ];
        }


        if (empty($rows))
        {
            return; //@todo Emil Vililyaev: для того чтобы не проверять if (!empty($data['rows'])... нужно отрефакторить все зависимые view
        }

        return ['rows' => $rows];
    }

    /**
     * Timestamp начала периода выборки
     *
     * @return number
     */
    protected function _getTimeFrom()
    {
        if (date("j") > $this->_monthThreshold)
        {
            $time = strtotime("first day of this month", strtotime(date("Y-m")));
        }
        else
        {
            $time = strtotime("first day of last month", strtotime(date("Y-m")));
        }

        return $time;
    }


    /**
     * Timestamp конца периода выборки
     *
     * @return number
     */
    protected function _getTimeTo()
    {
        return strtotime("first day of next month", $this->_getTimeFrom());
    }

    //-----------------------------------------------------------------------------------------------------------

    abstract protected function _process();

    abstract public function getTitle();

}