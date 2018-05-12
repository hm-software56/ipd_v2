<?php

Yii::import('application.models._base.BaseApplicationType');

class ApplicationType extends BaseApplicationType
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}