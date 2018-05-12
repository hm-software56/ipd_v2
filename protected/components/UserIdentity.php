<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    private $_username;
    
    public function getId() {
        return $this->_id;
    }
    
    public function getUserName() {
        return $this->_username;
    }
    
    /**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = User::model()->findByAttributes(
			array('username'=>$this->username, 'status'=>'Active')
		);
		if ($user == NULL) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else {
			/*if ($user->password !== crypt($this->password,$user->password)) {
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			}*/

			if ($user->password !==md5($this->password)) {
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			}
			else {
			    $user->last_login=date('Y-m-d H:i:s');
			    $user->update(array('last_login'));
				$this->_id = $user->id;
				$this->_username = $user->username;
				$this->errorCode = self::ERROR_NONE;
				$user->password=''; //not store password in session
				Yii::app()->session->add('user', $user);
			}
		}
		return !$this->errorCode;
	}
}