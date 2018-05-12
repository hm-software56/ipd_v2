<?php

/**
 * This is the model base class for the table "invest_mining".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "InvestMining".
 *
 * Columns in table "invest_mining" available as properties of the model,
 * followed by relations of table "invest_mining" available as properties of the model.
 *
 * @property integer $mining_id
 * @property integer $invest_company_id
 *
 * @property InvestCompany $investCompany
 * @property Mining $mining
 */
abstract class BaseInvestMining extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'invest_mining';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'InvestMining|InvestMinings', $n);
	}

	public static function representingColumn() {
		return 'mining_id';
	}

	public function rules() {
		return array(
			array('mining_id, invest_company_id', 'required'),
			array('mining_id, invest_company_id', 'numerical', 'integerOnly'=>true),
			array('mining_id, invest_company_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'investCompany' => array(self::BELONGS_TO, 'InvestCompany', 'invest_company_id'),
			'mining' => array(self::BELONGS_TO, 'Mining', 'mining_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'mining_id' => null,
			'invest_company_id' => null,
			'investCompany' => null,
			'mining' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('mining_id', $this->mining_id);
		$criteria->compare('invest_company_id', $this->invest_company_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}