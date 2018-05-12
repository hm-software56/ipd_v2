<?php

class SearchController extends GxController
{
	public function actionIndex()
	{
		$this->layout='column1';
		$this->render('index');
	}
	
	public function actionView()
	{
		$docID = Yii::app()->request->getParam('docid');
		$inorout = Yii::app()->request->getParam('inorout');
		if($docID)
		{
			if($inorout=="INC")
				$this->redirect(array('inDocument/'.$docID));
			elseif($inorout=="OUT")
				$this->redirect(array('outDocument/'.$docID));
			else{
				echo $inorout;exit;
				$this->redirect(array('search'));
			}
		}
	}
}