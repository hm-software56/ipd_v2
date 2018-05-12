<?php

Yii::import('appform.models._base.BaseApplicationStep');

class ApplicationStep extends BaseApplicationStep
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeDelete()
	 */
	public function beforeDelete()
	{
	    $appCount = ApplicationForm::model()->countByAttributes(array(
	        'application_step_id'=>$this->id,
	    ));
	    
	    if ($appCount > 0) {
	        return false;
	    } else {
	        return parent::beforeDelete();
	    }
	}
}