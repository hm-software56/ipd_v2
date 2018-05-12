<?php

Yii::import('application.models._base.BaseFromTo');

class FromTo extends BaseFromTo
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}