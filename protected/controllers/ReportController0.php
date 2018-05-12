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
		
		
		$year = date("Y");
		
		$app = ApplicationForm::model()->findAll();
		
		
		$gridDataProvider = new CArrayDataProvider(array(
		    array('id'=>1, 'Sector'=>'Agriculture', '1'=>'', '2'=>'', '3'=>'', '4'=>'', '5'=>'', '6'=>'', '7'=>'', '8'=>'', '9'=>'', '10'=>'', '11'=>'', '12'=>'', 'type'=>'Month'),
		    array('id'=>2, 'Sector'=>'Mining', '1'=>'', '2'=>'', '3'=>'', '4'=>'', '5'=>'', '6'=>'', '7'=>'', '8'=>'', '9'=>'', '10'=>'', '11'=>'', '12'=>'', 'type'=>'Month'),
		    array('id'=>3, 'Sector'=>'Hydro', '1'=>'', '2'=>'', '3'=>'', '4'=>'', '5'=>'', '6'=>'', '7'=>'', '8'=>'', '9'=>'', '10'=>'', '11'=>'', '12'=>'', 'type'=>'Month'),
		));
		$this->render('applicationReceived',array(
			'dataProvider'=>$gridDataProvider
		));
	}
	
	/**
	 * Action report of investment by province
	 */
	public function actionInvestmentLocation(){
		
		$this->render('investmentLocation',array(
			'dataprovider'=>NULL
		));
	}
	
	/**
	 * 
	 * Action report of response time line of each ministry
	 */
	public function actionResponseTime(){
		
		$this->render('responseTime',array(
			'dataprovider'=>NULL
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
}