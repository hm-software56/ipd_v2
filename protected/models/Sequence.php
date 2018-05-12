<?php

Yii::import('application.models._base.BaseSequence');

class Sequence extends BaseSequence
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}