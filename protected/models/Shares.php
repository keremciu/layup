<?php

/**
 * This is the model class for table "shares".
 *
 * The followings are the available columns in table 'shares':
 * @property integer $id
 * @property integer $shot_id
 * @property string $title
 * @property string $image_url
 * @property integer $player_id
 * @property string $created_at
 * @property integer $drafted_id
 * @property integer $is_finished
 */
class Shares extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Shares the static model class
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
		return 'shares';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shot_id, title, image_url, player_id, created_at, is_finished', 'required'),
			array('shot_id, player_id, drafted_id, is_finished', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, shot_id, title, image_url, player_id, created_at, drafted_id, is_finished', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', array('player_id'=>'player_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'shot_id' => 'Shot',
			'title' => 'Title',
			'image_url' => 'Image Url',
			'player_id' => 'Player',
			'created_at' => 'Created At',
			'drafted_id' => 'Drafted',
			'is_finished' => 'Is Finished',
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
		$criteria->compare('shot_id',$this->shot_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image_url',$this->image_url,true);
		$criteria->compare('player_id',$this->player_id);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('drafted_id',$this->drafted_id);
		$criteria->compare('is_finished',$this->is_finished);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}