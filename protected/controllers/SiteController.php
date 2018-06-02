<?php

class SiteController extends Controller
{
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		ini_set('memory_limit','-1');
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		unset(Yii::app()->session['Setting']);
		if(Yii::app()->user->id)
		{
			// Use for sort by organization or division 
			if(isset($_POST['division']))
			{
				$user_id=array();
				$userprs=UserProfile::model()->findAllByattributes(array('organization_id'=>(int)$_POST['division']));
				if(!empty($userprs))
				{
					foreach($userprs as $userpr)
					{
						$user_id[]=$userpr->user_id;
					}
				}
				Yii::app()->session['userid_groud_org']= $user_id;
				Yii::app()->session['division_id']= (int)$_POST['division'];
			}
			// end used

			$model = new IncDocument('search');
		    $model->unsetAttributes();
		    
		    $modelout=new OutDocument('search');
		    $modelout->unsetAttributes();
		    
		    $model_out_to_me = array();
		    
		    $myCriteria = new CDbCriteria;
		    $myCriteria->with =array("document.createdBy.userProfile","documentReceivers","document.documentType");
		    if(!Yii::app()->user->checkAccess("DG"))
		    	$myCriteria->addCondition("documentReceivers.to_organization_id='".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id."'");
		    
		    $myCriteria->addCondition("userProfile.organization_id !='".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id."'");
		    $myCriteria->addCondition("document_id not in (select document_id from related_doc_organization where to_organization_id='".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id."')
		    ");
			if(Yii::app()->user->checkAccess('DG'))
			{
				$myCriteria->limit=20;
			}
		    $model_out_to_me = OutDocument::model()->findAll($myCriteria);
		    
		    $model_out_to_me = new CArrayDataProvider($model_out_to_me, array(
			    'keyField'=>'document_id',
		    	'sort'=>array(
			        'attributes'=>array(
			            'out_document_no'=>array(
			                'asc'=>'out_document_no',
			                'desc'=>'out_document_no DESC',
			            ),
			        	'document_title'=>array(
			                'asc'=>'document_title',
			                'desc'=>'document_title DESC',
			            ),
			            'document_date'=>array(
			                'asc'=>'document_date',
			                'desc'=>'document_date DESC',
			            ),
			            'documentType.description'=>array(
			                'asc'=>'document.documentType.description',
			                'desc'=>'document.documentType.description DESC',
			            ),
			            '*',
			        ),
			        'defaultOrder'=>'document_id DESC',
			    ),
			    'pagination'=>array(
			        'pageSize'=>30,
			    ),
			));
		    
		    if (isset($_GET['IncDocument'])) 
		        $model->setAttributes($_GET['IncDocument']);
		        
		    if (isset($_GET['OutDocument'])) 
		        $modelout->setAttributes($_GET['OutDocument']);
		    
		    $this->render('index', array(
		        'model'=>$model,
		    	'modelout'=>$modelout,
		    	'model_out_to_me'=>$model_out_to_me,
		    	'docNo'=>''
		    ));
		}
		else
		{
		 	$this->redirect(array('login'));
		}
	}
	
	/**
	 * This is the action get session setting
	 */
	public function actionSetting()
	{
		Yii::app()->session['Setting']='Set';
		$this->redirect(array('/user/'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				if(Yii::app()->user->checkAccess('Accounting'))
				{
					$this->redirect(array('/caisse/admin'));
				}else{
					$this->redirect(Yii::app()->user->returnUrl);
				}
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
	    Yii::app()->session->add('user', NULL);
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function actionSearch()
	{
		$docNo = Yii::app()->request->getParam('docNo');
		$in_docs = array();
		$out_docs = array();
		$out_docs_to_me = array();
		
		if($docNo!=""){
			if(Yii::app()->user->checkAccess("DG")){
				$in_docs = IncDocument::model()->findAll("inc_document_no like '%$docNo%'");
				$out_docs = OutDocument::model()->findAll("out_document_no like '%$docNo%'");
				$out_docs_to_me = OutDocument::model()->findAll("out_document_no like '%$docNo%'");
			}else{
				$in_docs = IncDocument::model()->indoc_of_me()->findAll("inc_document_no like '%$docNo%'");
				$out_docs = OutDocument::model()->outdoc_of_me()->findAll("out_document_no like '%$docNo%'");
				$out_docs_to_me = OutDocument::model()->outdoc_to_me()->findAll("out_document_no like '%$docNo%'");
			}
		}

			$in_docs=new CArrayDataProvider($in_docs, array(
			    'keyField'=>'document_id',
				'sort'=>array(
			        'attributes'=>array(
			            '*',
			        ),
			        'defaultOrder'=>'t.id DESC',
		    	),
			    'pagination'=>array(
			        'pageSize'=>30,
			    ),
			));
	
			$out_docs=new CArrayDataProvider($out_docs, array(
			    'keyField'=>'document_id',
			    'pagination'=>array(
			        'pageSize'=>30,
			    ),
			));
			
			$out_docs_to_me=new CArrayDataProvider($out_docs_to_me, array(
			    'keyField'=>'document_id',
			    'pagination'=>array(
			        'pageSize'=>30,
			    ),
			));
		
		$this->render('search',array(
			'docNo'=>$docNo,
			'in_docs'=>$in_docs,
			'out_docs'=>$out_docs,
			'out_docs_to_me'=>$out_docs_to_me
		));
	}
		
	public function actionGetStatusList()
	{
		if(isset($_POST['in_or_out']))
		{
			$documentStatus=NULL;
			if($_POST['in_or_out']=="INC")
			{
				$documentStatus = DocumentStatus::model()->findAll("status_type='INC'");
			}elseif($_POST['in_or_out']=="OUT"){
				$documentStatus = DocumentStatus::model()->findAll("status_type='OUT'");
			}else{
				$documentStatus = DocumentStatus::model()->findAll();
			}
			
			$documentStatusList = CHtml::listData($documentStatus, 'id', 'status_description');
			
			$statusDropdown = CHtml::tag('option',array('value'=>''),CHtml::encode('--Please select--'),true);
			
			foreach ($documentStatusList as $value=>$name){
				$statusDropdown .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
			}
			
			echo CJSON::encode(array(
				'statusDropDown'=>$statusDropdown
			));
		}
	}

	public function actionIndocPublic($id)
	{
		$this->render('view_indoc', array(
			//'model' => $this->loadModel($id, 'IncDocument'),
			'model' => IncDocument::model()->findByPk($id),
		));
	}

	public function actionSearchPublic()
	{
		if(isset($_POST['code']))
		{
			$indoc=IncDocument::model()->findByAttributes(['inc_document_no'=>$_POST['code']]);
			if($indoc)
			{
				$this->redirect(array('/site/indocPublic', 'id' => $indoc->document_id));
			}else{
				Yii::app()->session['error']="ປ້ອນ​ເລກ​ທີເອ​ກະ​ສານ​ບໍ່​ຖືກ​ຕ້ອງ.";
			}
			$this->redirect(array('site/login'));
		}
	}
	public function actionBkdb()
	{
		Yii::import('ext.dumpDB.dumpDB');
		$dumper = new dumpDB('mysql:host=localhost;dbname=ipd_db_v2', 'root', '');
		$dumper = new dumpDB();
		$dumper->setRemoveViewDefinerSecurity(true);
		echo $dumper->getDump();
		echo "dddd";
	}
}