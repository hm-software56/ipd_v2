<?php

Yii::import('application.models._base.BaseItems');

class Items extends BaseItems
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}