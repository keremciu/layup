<?php

class UserIdentity extends CUserIdentity
{
	private $id;

	public function authenticate()
	{
        if (strpos($this->username, '@') !== false) {
            $record=Users::model()->findByAttributes(array('email'=>$this->username));
        } else {
            $record=Users::model()->findByAttributes(array('username'=>$this->username));
        }

        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else
        {
            $this->id=$record->id;
            $this->setState('token', $this->password);
            $this->setState('avatar_url', $record->avatar_url);
            $this->setState('type', $record->type);
            $this->setState('username', $record->username);
            $this->setState('name', $record->name);
            $this->setState('id', $record->id);           
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
 
    public function getId(){
        return $this->id;
    }
}

