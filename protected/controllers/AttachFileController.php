<?php

class AttachFileController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'AttachFile'),
		));
	}

	public function actionCreate() {
		$model = new AttachFile;
		$dataProvider = new CActiveDataProvider('AttachFile',
			array('criteria'=>array(
                    'with'=>array(
                        'document'=>array(
                            'condition'=>'document_id='.(int)$_GET['docid'].'',
                        ),
                    ),
                ))
		);

		if (isset($_POST['AttachFile'])) {
			$model->setAttributes($_POST['AttachFile']);
			
			$rnd = rand(0,9999);
			$uploadedFile=CUploadedFile::getInstance($model,'file_name');
			$filename= "{$rnd}_{$uploadedFile}";  // random number + file name
			$model->file_name=$filename;
			if($model->validate())
			if ($model->save()) {
				$uploadedFile->saveAs(Yii::app()->basePath.'/../file/'.$filename);  
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('create', 'docid' =>(int)$_GET['docid']));
			}
		}

		$this->render('create', array( 'model' => $model, 'dataProvider' => $dataProvider));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'AttachFile');


		if (isset($_POST['AttachFile'])) {
			$model->setAttributes($_POST['AttachFile']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'AttachFile')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('AttachFile');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new AttachFile('search');
		$model->unsetAttributes();

		if (isset($_GET['AttachFile']))
			$model->setAttributes($_GET['AttachFile']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	public function actionDownload($id)
		{
			$file =AttachFile::model()->findByPK($id);
			//echo Yii::app()->basePath; exit;
			header("Pragma: public"); // required
			
			if(substr($file->file_name, -3, 3)=="pdf")
				header('Content-Type: application/pdf');
			elseif (substr($file->file_name, -3, 3)=="jpg")
				header('Content-Type: image/jpeg'); 
			elseif (substr($file->file_name, -3, 3)=="doc")
				header('Content-type: application/msword'); 
			elseif (substr($file->file_name, -4, 4)=="docx")
				header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); 
			
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false); // required for certain browsers 
			//header("Content-Type: " . $file->mime_type);
			header("Content-Disposition: attachment; filename=\"" . str_replace(" ", "-", preg_replace("@[^a-z0-9 ]@", "", strtolower($file->file_name))) ."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize(Yii::app()->basePath . '/../file/' . $file->file_name ));
			readfile(Yii::app()->basePath . '/../file/' . $file->file_name );
			exit();
	 
		}
	

}