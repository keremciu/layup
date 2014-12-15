<?php

class Shots extends CActiveRecord
{
	public $getimage;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'shots';
	}

	public function rules()
	{
		return array(
			array('user_id, title, description, image', 'required'),
			array('user_id, likes_count, views_count, activate', 'numerical', 'integerOnly'=>true),
			array('updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
        	array('created_at,updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('title, image', 'length', 'max'=>255),
			array('image', 'file', 'types'=>'jpg,gif,png'),
			array('image','dimensionValidation'),
			array('id, user_id, title, description, image, likes_count, views_count, created_at, updated_at, activate', 'safe'),
		);
	}

	public function dimensionValidation($attribute,$param){
    	if(is_object($this->getimage)) {
        	list($width, $height) = getimagesize($this->getimage->tempName);
        	if($width!=800 || $height!=600) {
            	$this->addError('image','Image size should be 800x600 pixels.');
            }
        }
    }  


	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'title' => 'Title',
			'description' => 'Description',
			'image' => 'Image',
			'likes_count' => 'Likes Count',
			'views_count' => 'Views Count',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'activate' => 'Activate',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('likes_count',$this->likes_count);
		$criteria->compare('views_count',$this->views_count);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('activate',$this->activate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}