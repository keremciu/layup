<?php

class Users extends CActiveRecord
{
	private $_identity;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Users';
	}

	public function rules()
	{
		return array(
			array('player_id, name, username, type, created_at, updated_at, activate', 'required'),
			array('player_id, activate', 'numerical', 'integerOnly'=>true),
			array('name, username, location, type', 'length', 'max'=>255),
			array('id, player_id, name, username, html_url, avatar_url, bio, location, links, type, created_at, updated_at, activate', 'safe'),
		);
	}

	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$token);
			if(!$this->_identity->authenticate()) {}
		}
	}

	public function login($token)
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$token);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=3600*24*30; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'player_id' => 'Player',
			'name' => 'Name',
			'username' => 'Username',
			'html_url' => 'Html Url',
			'avatar_url' => 'Avatar Url',
			'bio' => 'Bio',
			'location' => 'Location',
			'links' => 'Links',
			'type' => 'Type',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'activate' => 'Activate',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('player_id',$this->player_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('html_url',$this->html_url,true);
		$criteria->compare('avatar_url',$this->avatar_url,true);
		$criteria->compare('bio',$this->bio,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('links',$this->links,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('activate',$this->activate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}