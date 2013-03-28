<?php

/**
 * This is the model class for table "parsed_emails".
 *
 * The followings are the available columns in table 'parsed_emails':
 * @property string $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $page
 * @property string $site
 */
class ParsedEmails extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ParsedEmails the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return CDbConnection database connection
     */
    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'parsed_emails';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, first_name', 'required'),
            array('email', 'length', 'max' => 100),
            array('email', 'email'),
            array('first_name, last_name, site', 'length', 'max' => 200),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, email, first_name, last_name, site', 'safe', 'on' => 'search'),
        );
    }

    public static function add($email, $name, $site, $page = null)
    {
        $exist = User::model()->findByAttributes(array('email' => $email));
        if ($exist === null)
            $exist = self::model()->findByAttributes(array('email' => $email));
        if ($exist === null)
            $exist = MailruUser::model()->findByAttributes(array('email' => $email));

        if ($exist === null) {
            $user = new self;
            $user->email = $email;
            $user->first_name = $name;
            $user->site = $site;
            if (!empty($page))
                $user->page = $page;
            $user->save();
        }
    }
}