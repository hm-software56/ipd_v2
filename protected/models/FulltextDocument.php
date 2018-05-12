<?php

Yii::import('application.models._base.BaseFulltextDocument');

class FulltextDocument extends BaseFulltextDocument
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function primaryKey()
	{
	  return 'id';
	}
}