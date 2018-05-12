<?php

class AppformModule extends CWebModule
{
    public $documentClass='IncDocument';
    public $documentId='document_id';
    public $documentNo='inc_document_no';
    public $documentTitle='document_title';
    public $documentDate ='document_date';
    
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'appform.models.*',
			'appform.components.*',
                        'appform.components.behaviors.*',
		));
		
		$this->configure(array(
		    'components'=>array(
		        /*'bootstrap'=>array(
		            'class'=>'appform.extensions.bootstrap.components.Bootstrap',
		            'responsiveCss'=>true,
		        ),*/
		        'multimodelform'=>array(
		            'class'=>'appform.extensions.multimodelform.MultiModelForm',
		        ),
		        'historyBehavior'=>array(
		            'class'=>'appform.components.behaviors.HistoryBehavior',
		        ),
		    )
		));
		
	 //if (!Yii::app()->hasComponent('bootstrap')) {
            //Yii::setPathOfAlias('bootstrap', realpath(dirname(__FILE__) . '/extensions/bootstrap'));
     //       Yii::createComponent('bootstrap.components.Bootstrap')->init();
      //  }
		//$this->getComponent('bootstrap');
		$this->getComponent('multimodelform');
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
