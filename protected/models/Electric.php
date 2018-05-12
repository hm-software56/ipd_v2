<?php

Yii::import('application.models._base.BaseElectric');

class Electric extends BaseElectric
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}