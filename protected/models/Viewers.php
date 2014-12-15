<?php

/**
 * This is the model class for table "viewers".
 *
 * The followings are the available columns in table 'viewers':
 * @property integer $id
 * @property integer $relevant_id
 * @property string $ip
 * @property string $user_agent
 * @property string $datetime
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Shots $relevant
 */
class Viewers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Viewers the static model class
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
		return 'viewers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('relevant_id, ip, user_agent, datetime', 'required'),
			array('relevant_id, user_id', 'numerical', 'integerOnly'=>true),
			array('ip', 'length', 'max'=>16),
			array('user_agent', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, relevant_id, ip, user_agent, datetime, user_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'relevant' => array(self::BELONGS_TO, 'Shots', 'relevant_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'relevant_id' => 'Relevant',
			'ip' => 'Ip',
			'user_agent' => 'User Agent',
			'datetime' => 'Datetime',
			'user_id' => 'User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('relevant_id',$this->relevant_id);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('datetime',$this->datetime,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}