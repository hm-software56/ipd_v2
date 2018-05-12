<?php

Yii::import('application.models._base.BaseOutDocumentHistory');

class OutDocumentHistory extends BaseOutDocumentHistory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	public function beforeSave()
	{
	    if ($this->document_date != '' && $this->document_date != '0000-00-00')
	    {
	        $this->document_date = date('Y-m-d',strtotime($this->document_date));
	    }
	    return parent::beforeSave();
	}
}