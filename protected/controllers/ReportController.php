<?php

class ReportController extends GxController
{
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * 
	 * Action report of applications received by sector
	 */
	public function actionApplicationReceived(){
		if(isset($_POST['year']))
			$years=(int)$_POST['year'];
		else 
			$years=null;
			
		$ArrMonth=array(1,2,3,4,5,6,7,8,9,10,11,12);
		$UserProfile=UserProfile::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		
		$this->render('applicationReceived', array('month'=>$ArrMonth,'regionID'=>$UserProfile,'years'=>$years));
	}
	
	/**
	 * Action report of investment by province
	 */
	public function actionInvestmentLocation(){
		
		if(isset($_POST['year']))
			$years=(int)$_POST['year'];
		else 
			$years=null;
			
		$UserProfile=UserProfile::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		$region=Region::model()->findAll();
		$this->render('investmentLocation',array(
			'region'=>$region,
			'regionID'=>$UserProfile,
			'years'=>$years,
		));
	}
	
	/**
	 * 
	 * Action report of response time line of each ministry
	 */
	public function actionResponseTime(){
		$ArrMonthHeader=array(1,2,3,4,5,6,7,8,9,10,11,12);
		$ArrMonth=array('01','02','03','04','05','06','07','08','09','10','11','12');
		if(isset($_POST['year']))
			$years=(int)$_POST['year'];
		else 
			$years=null;
			
		$UserProfile=UserProfile::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		
		$this->render('reponseTime',array(
			'month'=>$ArrMonth,
			'regionID'=>$UserProfile,
			'years'=>$years,
			'header'=>$ArrMonthHeader,
		));
	}
	
	/**
	 * 
	 * Action report of applications received by sector
	 */
	public function actionRegisteredCapital(){
		
		
		$this->render('registeredCapital',array(
			
			'dataprovider'=>NULL
		));
	}
	
	/* report Payment Recieve  form 
	 * 
	 */
	public function actionPaidRecieveForm()
	{
		$model=new Caisse;
		if(isset($_POST['Caisse']))
		{
			$model->attributes=$_POST['Caisse'];
			$paid=Caisse::model()->findAll('payment_status=1 AND DATE(payment_date) BETWEEN "'.date('Y-m-d',strtotime($model->start_date)).'" and "'.date('Y-m-d',strtotime($model->end_date)).'" ');
		}else{
			$paid=Caisse::model()->findAll('payment_status=1 AND YEAR(payment_date)="'.date('Y').'"');
		}
		$this->render('paidRecieve',array(
			'paid'=>$paid,
			'model'=>$model,
		));
	}
	/**
	 * 
	 * report Visa
	 */
	public function actionVisa()
	{
		$modelIndoc=new Document;
		if(isset($_POST['Document']))
		{
			$modelIndoc->attributes=$_POST['Document'];
		}
		
		$arrcountyears=Yii::app()->params->yearsVisa;
		foreach ($arrcountyears as $arrcountyears) {
			$Year[]=date('Y')-$arrcountyears;
		}
		
		$this->render('visa',array(
		'modelIndoc'=>$modelIndoc,
		'year'=>$Year
		));
	}
	
	/**
	 * 
	 * report General
	 */
	public function actionGeneralRecieve()
	{
		$modelIndoc=new Document;
		if(isset($_POST['Document']))
		{
			$modelIndoc->attributes=$_POST['Document'];
		}
		
		$arrcountyears=Yii::app()->params->yearsVisa;
		foreach ($arrcountyears as $arrcountyears) {
			$Year[]=date('Y')-$arrcountyears;
		}
		
		$this->render('generalRecieve',array(
		'modelIndoc'=>$modelIndoc,
		'year'=>$Year,
		'month'=>Yii::app()->params->Month,
		));
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function actionGeneralQualificationRecieve()
	{
		$modelIndoc=new Document;
		if(isset($_POST['Document']))
		{
			$modelIndoc->attributes=$_POST['Document'];
		}
		
		$arrcountyears=Yii::app()->params->yearsVisa;
		foreach ($arrcountyears as $arrcountyears) {
			$Year[]=date('Y')-$arrcountyears;
		}
		
		$this->render('generalQualificationRecieve',array(
		'modelIndoc'=>$modelIndoc,
		'year'=>$Year,
		'month'=>Yii::app()->params->Month,
		));
	}
	/**
	 * 
	 * Report Recieve App Count sector 
	 */
	public function actionRecieveApp()
	{
		$arrcountyears=Yii::app()->params->yearsVisa;
		$modelIndoc=new Document;
		if(isset($_POST['Document']))
		{
			$modelIndoc->attributes=$_POST['Document'];
			
			foreach ($arrcountyears as $arrcountyears) {
				$Year[]=$modelIndoc->start_date-$arrcountyears;
			}
			
		}
		else{
			foreach ($arrcountyears as $arrcountyears) {
				$Year[]=date('Y')-$arrcountyears;
			}
		}
		$UserProfile=UserProfile::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		
		$this->render('recieveApp',array(
		'modelIndoc'=>$modelIndoc,
		'year'=>$Year,
		'regionID'=>$UserProfile,
		));
	}
	
	/**
	 * 
	 */
	public function actionChangeLawApp()
	{
		$arrcountyears=Yii::app()->params->yearsVisa;
		$modelIndoc=new Document;
		if(isset($_POST['Document']))
		{
			$modelIndoc->attributes=$_POST['Document'];
			
			foreach ($arrcountyears as $arrcountyears) {
				$Year[]=$modelIndoc->start_date-$arrcountyears;
			}
			
		}
		else{
			foreach ($arrcountyears as $arrcountyears) {
				$Year[]=date('Y')-$arrcountyears;
			}
		}
		$UserProfile=UserProfile::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		
		$this->render('changeLawApp',array(
		'modelIndoc'=>$modelIndoc,
		'year'=>$Year,
		'regionID'=>$UserProfile,
		));
	}
}