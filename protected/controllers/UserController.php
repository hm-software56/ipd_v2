<?php

class UserController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'User'),
		));
	}

	public function actionCreate() {
		$model = new User;
		$assignment=new Assignments;

		if (isset($_POST['User']) && isset($_POST['UserProfile']) && isset($_POST['Organization'])) {
			$model->setAttributes($_POST['User']);
			$model->userProfile->setAttributes($_POST['UserProfile']);
			$model->userProfile->organization->setAttributes($_POST['Organization']);
			$assignment->setAttributes($_POST['Assignments']);
			
			//$model->userProfile->organization->id=$_POST['Organization']['id'];
			//$model->userProfile->organization_id=$_POST['UserProfile']['id'];
			
			//New user never login
			$model->last_login='0000-00-00 00:00:00';
			
			$valid = $model->validate(array(
			    'username',
			    'password',
			    'status'
			));
			
			$valid = $model->userProfile->validate(array(
			    'organization_id',
			    'first_name',
			    'last_name',
			    'title',
			    'birth_date',
			    'designation',
			    'telephone_number',
			    'mobile_number',
			    'email_address'
			));

			if ($valid && $model->save()) {
			    $model->userProfile->user_id=$model->id;
			    $model->userProfile->save();
			    $assignment->userid=$model->id;
			    $assignment->save();
			    
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('index'));
			}
		}

		$this->render('create', array( 'model' => $model,'assignment'=>$assignment));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'User');
		$assignment=Assignments::model()->findByAttributes(array('userid'=>$id));


		if (isset($_POST['User']) && isset($_POST['UserProfile']) && isset($_POST['Organization'])) {
			$model->setAttributes($_POST['User']);
			$model->userProfile->setAttributes($_POST['UserProfile']);
			$model->userProfile->organization->setAttributes($_POST['Organization']);
			$assignment->setAttributes($_POST['Assignments']);
			
					
			$valid = $model->validate(array(
			    'username',
			    'password',
			    'status'
			));
			
			$valid = $model->userProfile->validate(array(
			    'organization_id',
			    'first_name',
			    'last_name',
			    'title',
			    'birth_date',
			    'designation',
			    'telephone_number',
			    'mobile_number',
			    'email_address'
			));

			if ($valid && $model->save()) {
			    $model->userProfile->save();
			    $assignment->save();
			    
				$this->redirect(array('index'));
			}
		}

		$this->render('update', array(
				'model' => $model,
				'assignment'=>$assignment,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'User')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new User('search');
		$model->unsetAttributes();
		
		if (isset($_GET['User']))
		    $model->setAttributes($_GET['User']);
		    
	    $this->render('index', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new User('search');
		
		$model->unsetAttributes();

		if (isset($_GET['User']))
			$model->setAttributes($_GET['User']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	public function actionLoadTree()
	{
	    $result = CHtml::tag('option',array('value'=>''),CHtml::encode(Yii::t('app', '--Please select--')),true);
	    $roots=Organization::model()->findAll(
			'parent_id IS NULL AND region_id='
            .(int)$_POST['Organization']['region_id']
        );
        
	    foreach ($roots as $root)
	    {
	        $result .= CHtml::tag('option',
	            array('value'=>$root->id),
                CHtml::encode($root->organization_name),
	            true
	        );
	        $result .= Organization::getChild($root->id);
	    }
	    echo $result;
	}
	
	public function actionChangepassword()
	{
		$id=Yii::app()->user->id;
		$models =User::model()->findByPK($id);
		
		if(isset($_POST['User']))
		{
			if(!empty($_POST['User']['password_new']))
			{
				$password=$_POST['User']['password'];
				$password_new=md5($_POST['User']['password_new']);
				$password_old=md5($_POST['User']['password_old']);
				if($password_old==$password)
				{
					User::model()->updateByPk($id,array('password'=>$password_new));
					$this->redirect(Yii::app()->user->returnUrl);
				}else {
					Yii::app()->user->setFlash('error',Yii::t('app','Password old incorrect'));
				}
			}else{
				Yii::app()->user->setFlash('empty',Yii::t('app','Please input new password'));
			}
		}
		$this->render('changepassword',array('model'=>$models));
	}
	
	public function actionChangeprofile()
	{
		$id=Yii::app()->user->id;
		$model = $this->loadModel($id, 'User');
		if(isset($_POST['UserProfile']))
		{
			//echo $model->userProfile->user_id; exit;
			$model->userProfile->title=$_POST['UserProfile']['title'];
			$model->userProfile->first_name=$_POST['UserProfile']['first_name'];
			$model->userProfile->last_name=$_POST['UserProfile']['last_name'];
			$model->userProfile->birth_date=$_POST['UserProfile']['birth_date'];
			$model->userProfile->designation=$_POST['UserProfile']['designation'];
			$model->userProfile->telephone_number=$_POST['UserProfile']['telephone_number'];
			$model->userProfile->mobile_number=$_POST['UserProfile']['mobile_number'];
			$model->userProfile->email_address=$_POST['UserProfile']['email_address'];
			if($model->userProfile->save())
			{
				$this->redirect(array('site/index/'));
			}
			
		}
		
		$this->render('changeprofile',array('model'=>$model));
	}
	/**
	 * 
	 * Admin use to change password and username
	 */
	public function actionAdminchangepassword()
	{
		$model=User::model()->findByPK((int)$_GET['id']);
		$username=$model->username;
		$password=$model->password;
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->password=md5($model->password);
			if($model->username !==$username || $model->password !==$password)
			{
				$model->save();
			}
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		$this->render('adminchangepassword',array('model'=>$model));
	}
}