<?php

/**
 * This is the model base class for the table "user_profile".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "UserProfile".
 *
 * Columns in table "user_profile" available as properties of the model,
 * followed by relations of table "user_profile" available as properties of the model.
 *
 * @property integer $user_id
 * @property integer $organization_id
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $birth_date
 * @property string $designation
 * @property string $telephone_number
 * @property string $mobile_number
 * @property string $email_address
 *
 * @property Organization $organization
 * @property User $user
 */
abstract class BaseUserProfile extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'user_profile';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'UserProfile|UserProfiles', $n);
	}

	public static function representingColumn() {
		return 'title';
	}

	public function rules() {
		return array(
			array('user_id, organization_id, title, first_name', 'required'),
			array('user_id, organization_id', 'numerical', 'integerOnly'=>true),
			array('title, email_address', 'length', 'max'=>60),
			array('first_name, last_name, designation', 'length', 'max'=>255),
			array('telephone_number, mobile_number', 'length', 'max'=>45),
			array('birth_date', 'safe'),
			array('last_name, birth_date, designation, telephone_number, mobile_number, email_address', 'default', 'setOnEmpty' => true, 'value' => null),
			array('user_id, organization_id, title, first_name, last_name, birth_date, designation, telephone_number, mobile_number, email_address', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'organization' => array(self::BELONGS_TO, 'Organization', 'organization_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'user_id' => null,
			'organization_id' => null,
			'title' => Yii::t('app', 'Title'),
			'first_name' => Yii::t('app', 'First Name'),
			'last_name' => Yii::t('app', 'Last Name'),
			'birth_date' => Yii::t('app', 'Birth Date'),
			'designation' => Yii::t('app', 'Designation'),
			'telephone_number' => Yii::t('app', 'Telephone Number'),
			'mobile_number' => Yii::t('app', 'Mobile Number'),
			'email_address' => Yii::t('app', 'Email Address'),
			'organization' => null,
			'user' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('organization_id', $this->organization_id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('first_name', $this->first_name, true);
		$criteria->compare('last_name', $this->last_name, true);
		$criteria->compare('birth_date', $this->birth_date, true);
		$criteria->compare('designation', $this->designation, true);
		$criteria->compare('telephone_number', $this->telephone_number, true);
		$criteria->compare('mobile_number', $this->mobile_number, true);
		$criteria->compare('email_address', $this->email_address, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}