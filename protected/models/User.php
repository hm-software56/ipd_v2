<?php

Yii::import('application.models._base.BaseUser');

class User extends BaseUser
{
    public $first_name;
    public $last_name;
    public $organization_name;
    public $organization_id;
    public $password_old;
    public $password_new;
    
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CModel::afterConstruct()
	 */
	public function afterConstruct()
	{
	    parent::afterConstruct();
	    $this->userProfile=new UserProfile();
	    $this->userProfile->organization=new Organization();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterFind()
	 */
	public function afterFind()
	{
	    parent::afterFind();
	    $profile=null;
	    $organization=null;
	    
	    $profile=$this->userProfile;
	    $organization= ($profile != null) 
	        ? $organization=$profile->organization : null;
	    
	    $this->first_name=($profile != null) ? $profile->first_name : '';
	    $this->last_name=($profile != null) ? $profile->last_name : '';
	    $this->organization_name=($organization != null) 
	        ? $organization->organization_name : '';
	    $this->organization_id=($profile != null) ? $profile->organization_id : '';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CModel::afterValidate()
	 */
	public function afterValidate()
	{
	    parent::afterValidate();
	    $this->userProfile->validate();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	public function beforeSave()
	{
	    // New record only
	    if ($this->isNewRecord)
	    {
			//Encrypt password
			//$this->password = crypt($this->password,$this->password);
			$this->password = md5($this->password);
	    }
	    return parent::beforeSave();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see BaseUser::rules()
	 */
	public function rules()
	{
	    $parent=parent::rules();
	    $new = array(
	        array(
				'first_name,last_name,organization_name', 
				'safe', 
				'on'=>'search'
	        ),
	        array(
	            'last_login','unsafe','on'=>'create,update'
	        )
	    );
	    return array_merge($parent,$new);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see BaseUser::search()
	 */
	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->with=array(
		    'userProfile',
		    'userProfile.organization',
		);

		$criteria->compare('id', $this->id);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('last_login', $this->last_login, true);
		$criteria->compare('userProfile.first_name', $this->first_name,true);
		$criteria->compare('userProfile.last_name',$this->last_name,true);
		$criteria->compare('organization.organization_name', $this->organization_name,true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		    'sort'=>array(
		        'attributes'=>array(
		            'first_name'=>array(
		                'asc'=>'userProfile.first_name',
		                'desc'=>'userProfile.last_name DESC',
		            ),
		            'last_name'=>array(
		                'asc'=>'userProfile.last_name',
		                'desc'=>'userProfile.last_name DESC',
		            ),
		            'organization_name'=>array(
		                'asc'=>'organization.organization_name',
		                'desc'=>'organization.organization_name DESC',
		            ),
		            '*',
		        )
		    ),
		    'pagination'=>array(
		        'pageSize'=>50
		    )
		));
	}
	
	public static function getshowrule($id){
		$str="";
			//$comment=Comment::model()->findByAttributes(array('id'=>$readcoments->comment_id,'document_id'=>$id));
			$showrule=Assignments::model()->findByAttributes(array('userid'=>$id));
			$str.="<ul style='list-style-type: none; margin-left:-20px' >";
							
				if(!empty($showrule))
				{
				 $str.="<li><span class='span1'>".$showrule->itemname." </span></li>";
				}
			$str.="</ul>";
		return $str;
	}
}