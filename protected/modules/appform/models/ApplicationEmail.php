<?php

Yii::import('appform.models._base.BaseApplicationEmail');

class ApplicationEmail extends BaseApplicationEmail
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}