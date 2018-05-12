<?php

Yii::import('application.models._base.BaseIncDocumentHistory');

class IncDocumentHistory extends BaseIncDocumentHistory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function beforeSave()
	{
	    if ($this->document_date != '' && $this->document_date != '0000-00-00') {
	        $this->document_date = date('Y-m-d', strtotime($this->document_date));
	    }
		if ($this->last_modified != '' && $this->last_modified != '0000-00-00 00:00:00') {
	        $this->last_modified = date('Y-m-d H:i:s', strtotime($this->last_modified));
	    }
	    return parent::beforeSave();
	}
	
	public function afterFind()
	{
	if ($this->last_modified != '' && $this->last_modified != '0000-00-00 00:00:00') {
	        $this->last_modified = date('d-m-Y H:i:s', strtotime($this->last_modified));
	    }
	}
}