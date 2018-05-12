<?php

/**
 * This is the model base class for the table "invest_company_history".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "InvestCompanyHistory".
 *
 * Columns in table "invest_company_history" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $company_name
 * @property string $register_place
 * @property string $register_date
 * @property integer $total_capital
 * @property integer $capital
 * @property string $president_first_name
 * @property string $president_last_name
 * @property string $president_nationality
 * @property string $president_position
 * @property string $headquarter_address
 * @property string $business_sector
 * @property integer $user_action_id
 * @property string $action_time
 *
 */
abstract class BaseInvestCompanyHistory extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'invest_company_history';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'InvestCompanyHistory|InvestCompanyHistories', $n);
	}

	public static function representingColumn() {
		return 'company_name';
	}

	public function rules() {
		return array(
			array('id, company_name, register_place, register_date, total_capital, capital, president_first_name, president_last_name, president_nationality, president_position, headquarter_address, business_sector, user_action_id, action_time', 'required'),
			array('id, total_capital, capital, user_action_id', 'numerical', 'integerOnly'=>true),
			array('company_name, register_place, president_first_name, president_last_name, president_nationality, president_position, headquarter_address, business_sector', 'length', 'max'=>255),
			array('id, company_name, register_place, register_date, total_capital, capital, president_first_name, president_last_name, president_nationality, president_position, headquarter_address, business_sector, user_action_id, action_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'company_name' => Yii::t('app', 'Company Name'),
			'register_place' => Yii::t('app', 'Register Place'),
			'register_date' => Yii::t('app', 'Register Date'),
			'total_capital' => Yii::t('app', 'Total Capital'),
			'capital' => Yii::t('app', 'Capital'),
			'president_first_name' => Yii::t('app', 'President First Name'),
			'president_last_name' => Yii::t('app', 'President Last Name'),
			'president_nationality' => Yii::t('app', 'President Nationality'),
			'president_position' => Yii::t('app', 'President Position'),
			'headquarter_address' => Yii::t('app', 'Headquarter Address'),
			'business_sector' => Yii::t('app', 'Business Sector'),
			'user_action_id' => Yii::t('app', 'User Action'),
			'action_time' => Yii::t('app', 'Action Time'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('company_name', $this->company_name, true);
		$criteria->compare('register_place', $this->register_place, true);
		$criteria->compare('register_date', $this->register_date, true);
		$criteria->compare('total_capital', $this->total_capital);
		$criteria->compare('capital', $this->capital);
		$criteria->compare('president_first_name', $this->president_first_name, true);
		$criteria->compare('president_last_name', $this->president_last_name, true);
		$criteria->compare('president_nationality', $this->president_nationality, true);
		$criteria->compare('president_position', $this->president_position, true);
		$criteria->compare('headquarter_address', $this->headquarter_address, true);
		$criteria->compare('business_sector', $this->business_sector, true);
		$criteria->compare('user_action_id', $this->user_action_id);
		$criteria->compare('action_time', $this->action_time, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}