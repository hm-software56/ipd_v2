<?php

Yii::import('application.models._base.BaseUserProfile');

class UserProfile extends BaseUserProfile
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterFind()
	 */
	public function afterFind()
	{
	    parent::afterFind();
	    if ($this->birth_date != '0000-00-00')
	    {
	        $this->birth_date=date('d-M-Y',strtotime($this->birth_date));
	    }
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	public function beforeSave()
	{
	    if ($this->birth_date != '' && $this->birth_date != '0000-00-00')
	    {
	        $this->birth_date=date('Y-m-d',strtotime($this->birth_date));
	    }
	    return parent::beforeSave();
	}
}