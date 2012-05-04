<?php
class CommentProduct extends Comment
{
    public $response_id = null;
    public $quote_id = null;


    /**
     * Returns the static model of the specified AR class.
     * @return Comment the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'comments_product';
    }

    public function rules()
    {
        return CMap::mergeArray(parent::rules(), array(
            array('rating', 'numerical', 'integerOnly' => true),
        ));
    }
}
