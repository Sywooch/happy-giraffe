<?php

namespace site\frontend\modules\geo2\components\fias\models;

/**
 * This is the model class for table "FIAS__ADDROBJ".
 *
 * The followings are the available columns in table 'FIAS__ADDROBJ':
 * @property string $AOGUID
 * @property string $FORMALNAME
 * @property string $REGIONCODE
 * @property string $AUTOCODE
 * @property string $AREACODE
 * @property string $CITYCODE
 * @property string $CTARCODE
 * @property string $PLACECODE
 * @property string $STREETCODE
 * @property string $EXTRCODE
 * @property string $SEXTCODE
 * @property string $OFFNAME
 * @property string $POSTALCODE
 * @property string $IFNSFL
 * @property string $TERRIFNSFL
 * @property string $IFNSUL
 * @property string $TERRIFNSUL
 * @property string $OKATO
 * @property string $OKTMO
 * @property string $UPDATEDATE
 * @property string $SHORTNAME
 * @property string $AOLEVEL
 * @property string $PARENTGUID
 * @property string $AOID
 * @property string $PREVID
 * @property string $NEXTID
 * @property string $CODE
 * @property string $PLAINCODE
 * @property string $ACTSTATUS
 * @property string $CENTSTATUS
 * @property string $OPERSTATUS
 * @property string $CURRSTATUS
 * @property string $STARTDATE
 * @property string $ENDDATE
 * @property string $NORMDOC
 * @property string $LIVESTATUS
 * @property string $CADNUM
 * @property string $DIVTYPE
 */
class FiasAddrobj extends \CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'FIAS__ADDROBJ';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [

		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'AOGUID' => 'Aoguid',
			'FORMALNAME' => 'Formalname',
			'REGIONCODE' => 'Regioncode',
			'AUTOCODE' => 'Autocode',
			'AREACODE' => 'Areacode',
			'CITYCODE' => 'Citycode',
			'CTARCODE' => 'Ctarcode',
			'PLACECODE' => 'Placecode',
			'STREETCODE' => 'Streetcode',
			'EXTRCODE' => 'Extrcode',
			'SEXTCODE' => 'Sextcode',
			'OFFNAME' => 'Offname',
			'POSTALCODE' => 'Postalcode',
			'IFNSFL' => 'Ifnsfl',
			'TERRIFNSFL' => 'Terrifnsfl',
			'IFNSUL' => 'Ifnsul',
			'TERRIFNSUL' => 'Terrifnsul',
			'OKATO' => 'Okato',
			'OKTMO' => 'Oktmo',
			'UPDATEDATE' => 'Updatedate',
			'SHORTNAME' => 'Shortname',
			'AOLEVEL' => 'Aolevel',
			'PARENTGUID' => 'Parentguid',
			'AOID' => 'Aoid',
			'PREVID' => 'Previd',
			'NEXTID' => 'Nextid',
			'CODE' => 'Code',
			'PLAINCODE' => 'Plaincode',
			'ACTSTATUS' => 'Actstatus',
			'CENTSTATUS' => 'Centstatus',
			'OPERSTATUS' => 'Operstatus',
			'CURRSTATUS' => 'Currstatus',
			'STARTDATE' => 'Startdate',
			'ENDDATE' => 'Enddate',
			'NORMDOC' => 'Normdoc',
			'LIVESTATUS' => 'Livestatus',
			'CADNUM' => 'Cadnum',
			'DIVTYPE' => 'Divtype',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FiasAddrobj the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
