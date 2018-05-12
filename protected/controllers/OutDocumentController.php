<?php

class OutDocumentController extends GxController {
	
	public $_receivers = NULL;

	public function actionView($id) {
		
		if(Yii::app()->user->checkAccess("DG"))
		{
			if(isset($_POST['Comment']))
			{
				$comment = new Comment;
			
				$comment->attributes = $_POST['Comment'];
				$comment->document_id = $id;
				$comment->user_id = Yii::app()->user->id;
				$comment->comment_time = date('Y-m-d H:i:s');
				if(isset($_POST['toUsers']))
				{
					if($comment->save())
					{
						foreach($_POST['toUsers'] as $user_id)
						{
							$comment_2_users = new CommentToUser;
							$comment_2_users->comment_id = $comment->id;
							$comment_2_users->user_id = $user_id; 
							$comment_2_users->save();
						}
					}
				}
			}
		}else{
			$comment=Comment::model()->findAllByAttributes(array('document_id'=>$id));
			foreach ($comment as $comments)
			{
				$commentToUser=CommentToUser::model()->findAllByAttributes(array('comment_id'=>$comments->id,'user_id'=>Yii::app()->user->id));
				if(!is_object($commentToUser))
				{
					foreach ($commentToUser as $commentToUsers)
					{
						$updatestatus=CommentToUser::model()->findByPK($commentToUsers->id);
						$updatestatus->status="Read";
						$updatestatus->save();
						
					}
				}
			}
			
		}
		$this->render('view', array(
			'model' => $this->loadModel($id, 'OutDocument')
		));
	}
/*	
	public function beforeAction(){
		if($this->action->id=="create"){
//    		Yii::app()->user->setState('receivers',NULL);
    	}
        return true;
    }
    */
	public function actionCreate() {
		
		$model = new OutDocument;
		$model->document = new Document;
		$comment = new Comment;
		
		$receiver = new DocumentReceiver;
		$connection = Yii::app()->db;
		$transaction = null;
		
		if (isset($_POST['Document'])) {
			$model->document->setAttributes($_POST['Document']);
			$comment->setAttributes($_POST['Comment']);
			
			$user = Yii::app()->session->get('user');
			
			//$model->document->document_date = date('d-m-Y');
			$model->document->created = date('Y-m-d H:i:s');
			$model->document->created_by = $user->id;
			$model->document->last_modified = $model->document->created;
			$model->document->last_modified_id = $user->id;
			$model->document->in_or_out = 'OUT';
			
			$transaction = $connection->beginTransaction();
			try {
			    
			    if (!$model->document->save())
			    	throw new Exception('Cannot save Document');
			    
				if(!empty( $comment->comment_detail))
			    {
			    	$comment->document_id = $model->document->id;
			    	$comment->user_id=$user->id;
					$comment->comment_time=date('Y-m-d H:i:s');
				    if(!$comment->save())
				   		throw new Exception('Cannot save comments');
			    }
			    
			    $model->document_id=$model->document->id;
			    
			    if (!$model->save())
			    throw new Exception('Cannot save Outgoing Document');
			    
			    // save Docreceivers
			    $arrayReceivers =Yii::app()->user->getState('receivers');
				if(count($arrayReceivers))
				{
					foreach($arrayReceivers as $oneReiv)
					{
						$oneReiv->out_document_id = $model->document_id;
						if (!$oneReiv->save())
						    throw new Exception('Cannot save Receiver document');
					}
				}
			    Yii::app()->user->setState('receivers',NULL);

			    $transaction->commit();
			    Yii::app()->user->setFlash('success', 'New document no. <strong>'.$model->document_no.'</strong> has been created successfully.');
			    $this->redirect(array('view','id'=>$model->document_id));
			} catch (Exception $e) {
			    $transaction->rollback();
			    Yii::app()->user->setFlash('error', '<strong>Error!</strong> Fix things up and submit again.'.$e->getMessage());
			}
		}
		if(Yii::app()->user->getState('receivers')==NULL)
			Yii::app()->user->setState('receivers',$model->receivers);
			
		$this->render('create', array( 
			'model' => $model,
			'comment' => $comment,
			'receiver' => $receiver)
		);
	}

	public function actionUpdate($id) {
		//$model = $this->loadModel($id, 'OutDocument');
                $model = OutDocument::model()->findByPk($id);//$this->loadModel($id, 'OutDocument');
		$receiver = new DocumentReceiver;
		$comment = new Comment;
		
		$connection = Yii::app()->db;
		$transaction = null;
			
		if (isset($_POST['Document'])) {
			
			$model->document->setAttributes($_POST['Document']);
			$comment->setAttributes($_POST['Comment']);
			
			$user = Yii::app()->session->get('user');
			
			$model->document->last_modified_id = $user->id;
			
			$transaction = $connection->beginTransaction();
							
			try {
				if (!$model->document->save()){
					//print_r($model->document->attributes);exit;
			    	throw new Exception('Cannot save Document');
				}
			    
				if(!empty( $comment->comment_detail)) {
			    	$comment->document_id = $model->document->id;
			    	$comment->user_id=$user->id;
					$comment->comment_time=date('Y-m-d H:i:s');
				    if(!$comment->save()){
				    	//print_r($comment->attributes);exit;
				    	throw new Exception('Cannot save comments');
				    }
			    }
			    
				$memory =Yii::app()->user->getState('receivers');
//			echo count($arrayReceivers);exit;
				$new_insert = $memory;
                $arrayloop = $model->documentReceivers;
				$to_delete  = ($model->documentReceivers)?$model->documentReceivers:NULL;
                $del = array();
                $new =array();
				if(count($memory)){
					foreach($memory as $key=>$oneReiv){
						if($model->documentReceivers){
					   // echo count($model->documentReceivers)."<br>";
							$exist = false;
							$key=-1;
							foreach($model->documentReceivers as $keydel=>$r){
									if(!$r->compare($oneReiv)){ // if same
											$exist = true;
											$key = $keydel;
											$new_insert = array_splice($new_insert,$key,1);
									$to_delete = array_splice($to_delete,$keydel,1);			
								}			
							}
							if(!$exist){
								$new[]=$oneReiv;
							}
						}else{
							$new = $memory;
						}
					}
                                        
					foreach($model->documentReceivers as $keydb=>$fromdb){
						$exist = false;
						foreach($memory as $keymem=>$mem){
							if(!$fromdb->compare($mem)){ // if same
								$exist = true;		
							}
						}
						if(!$exist){
							  $del[]=$fromdb;
							  $to_delete = $del;
						}
					}
                                        
                          //              echo "New Insert =".count($new_insert)."<br>";
                           //             echo "to delete =".count($to_delete);
                                        
//                                        exit;
					if($new){
                                        //if($new_insert)	{
                                                foreach ($new as $in){
						//foreach ($new_insert as $in){
                                			$in->out_document_id = $model->document_id;                      
							$in->save();
                                                       // echo "New ".$in->receiver_name."<br>";
						}
					}
                                        if($del){
					//if($to_delete){
                                              foreach ($del as $dell){
						//foreach ($to_delete as $del){
							$dell->delete();
                                                    //    DocumentReceiver::model()->findByPk($del->id)->delete();
                                                        echo "deleted id=".$dell->id.' '.$dell->receiver_name."<br>";
						}
					}
				}else{	// delete old records if exists
					if($model->documentReceivers)
						foreach ($model->documentReceivers as $del){
							$del->delete();
						}
				}				
								
				$model->save();
				$transaction->commit();
				Yii::app()->user->setState('receivers',NULL);
                              //  exit;
				$this->redirect(array('view', 'id' => $model->document_id));
					
			}catch (Exception $e) {
			    $transaction->rollback();
			    Yii::app()->user->setFlash('error', '<strong>Error!</strong> Fix things up and submit again.'.$e->getMessage());
			}
		}
		
		if(Yii::app()->user->getState('receivers')==NULL)
			Yii::app()->user->setState('receivers',$model->receivers);
						
		$this->render('update', array(
				'model' => $model,
				'comment' => $comment,
				'receiver' => $receiver
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'OutDocument')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		Yii::app()->user->setState('receivers',NULL);
		$model = new OutDocument('search');
		$model->unsetAttributes();

		if (isset($_GET['OutDocument']))
			$model->setAttributes($_GET['OutDocument']);
		
			$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		Yii::app()->user->setState('receivers',NULL);
		$model = new OutDocument('search');
		$model->unsetAttributes();

		if (isset($_GET['OutDocument']))
			$model->setAttributes($_GET['OutDocument']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	public function actionAddReceiver() {
		
		if(Yii::app()->request->isAjaxRequest)
		{
			$rev =Yii::app()->user->getState('receivers');
			if(isset($_POST['DocumentReceiver'])){
				$docRec = new DocumentReceiver;
				$docRec->status_date = date('d-m-Y H:i:s');
				$docRec->setAttributes($_POST['DocumentReceiver']);
				$valid = $docRec->validate(array('to_organization_id','document_status_id','receive_name'));
				 
				if($valid){
					$rev[]=$docRec;
					Yii::app()->user->setState('receivers',$rev);
				}
			}
		}
		$this->renderPartialWithHisOwnClientScript('_receivers'); // good
	}
	
	
	public function actionDelReceiver() {
		
		if(Yii::app()->request->isAjaxRequest)
		{
			$index = Yii::app()->request->getParam('idx');
			
			$rev =Yii::app()->user->getState('receivers');
			if(count($rev)){
				array_splice($rev,$index,1);
				Yii::app()->user->setState('receivers',$rev);
			}
			$this->renderPartialWithHisOwnClientScript('_receivers'); // good
		}
	}
	
	/**
	 * 
	 * List all Document to select related document
	 */
	public function actionListdocuments(){
		$documents = new Document('search');
		$documents->unsetAttributes();
		
		$myCriteria = new CDbCriteria;
		
		
		$options = Yii::app()->request->getParam('docOptions');
		switch($options)
		{
			case 'Incoming': // get incomming doc of my dept
					$documents->in_or_out = "INC";
					$myCriteria->join="INNER JOIN user on user.id=t.created_by INNER JOIN user_profile on user_profile.user_id=user.id";
					$myCriteria->addCondition("
						organization_id=".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id.
						" and in_or_out='INC'"
					);break;
			case 'Outgoing': // get outgoing doc of my dept
					$documents->in_or_out = "OUT";
					$myCriteria->join="INNER JOIN user on user.id=t.created_by INNER JOIN user_profile on user_profile.user_id=user.id";
					$myCriteria->addCondition("
						organization_id=".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id.
						" and in_or_out='Out'"
					);break;
			case 'Other': // get document not yet related
					$documents->in_or_out = "OUT";
					$myCriteria->join="INNER JOIN document_receiver on document_receiver.out_document_id=t.id and to_organization_id='".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id."'";
					$myCriteria->addCondition("t.id not in (select document_id from related_doc_organization where to_organization_id='".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id."')");
					break;
			/*case 'Other': // get document not yet related
					$myCriteria->join="INNER JOIN unrelated_doc_to_me on unrelated_doc_to_me.document_id=t.id";
					$myCriteria->addCondition("
						unrelated_doc_to_me.to_organization_id=".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id);
					break;*/
		}			
		
		
		if(Yii::app()->request->getIsAjaxRequest())
		{
			//$docID='';
			//$docID = Yii::app()->request->getParam('docID');
			if(Yii::app()->request->getParam('docID')!="")
			{
				$docID = Yii::app()->request->getParam('docID');
			}else{
				$docID='Null';
			}
		//	if(!$docID)
			if(isset($_GET['Document']))
				$documents->setAttributes($_GET['Document']);
				
			$providers =$documents->search($myCriteria,array('pageSize'=>5));
			
			if($documents->document_date){
				if ($documents->document_date != '' && $documents->document_date != '0000-00-00')
			    {
			        $documents->document_date = date('d-m-Y',strtotime($documents->document_date));
			    }
			}
			/*$this->renderPartial('_listdocuments',
				array('docID'=>$docID,'documents'=>$documents,'providers'=>$providers));*/
			
		}
		
		$this->renderPartialWithHisOwnClientScript('_listdocuments',
				array(
					'docID'=>$docID,
					'documents'=>$documents,
					'providers'=>$providers,
					'myCriteria'=>$myCriteria,
				
				)
		); // good
		return true;
	}
	
	/**
	 * 
	 * Ajax action to select related document
	 */
	public function actionselectDoc(){
		$docID = Yii::app()->request->getParam('id');
		$doc = Document::model()->findByPk($docID);
		$this->renderPartial('document_selected',array('document'=>$doc));
	}
	
	public function actionViewDocument()
	{
		$docID = Yii::app()->request->getParam('id');
		$type = Yii::app()->request->getParam('inout');
		switch($type)
		{
			case 'INC':
				$this->redirect(Yii::app()->createUrl('inDocument/view',array('id'=>$docID)));
			case 'OUT':
				$this->redirect(Yii::app()->controller->createUrl('view',array('id'=>$docID)));
		}
	}

	/*
	public function actionChangeStatus()
	{
		$receiverID =  Yii::app()->request->getParam('receiverid');
		if($receiverID)
			$rev = DocumentReceiver::model()->findByPk($receiverID);
		if(isset($_POST['DocumentReceiver'])){
			if($_POST['DocumentReceiver']['id']){
				$rev = DocumentReceiver::model()->findByPk($_POST['DocumentReceiver']['id']);
				$rev->document_status_id = $_POST['DocumentReceiver']['document_status_id'];
				
				if($rev->save())
					$this->redirect(Yii::app()->request->urlReferrer);
			}
		}
			
		//$this->renderPartialWithHisOwnClientScript('_changestatus',
		$this->renderPartial('_changestatus',
				array('receiver'=>$rev)
		); // good
	}
	

	public function actionUpdateStatus()
	{
		$result=NULL;
		$receiverID =  Yii::app()->request->getParam('receiverid');
		$document_status_id =  Yii::app()->request->getParam('document_status_id');
		
		if($receiverID!="" && $document_status_id!="")
		{
			$rev = DocumentReceiver::model()->findByPk($receiverID);
			$rev->document_status_id = $document_status_id;
			if($rev->save()){
				$result = "success";
			}
		}else{
			$result = "failed";
		}
		echo CJSON::encode(array(
			'result'=>$result,
			'docNo'=>Yii::app()->request->getParam('docNo'),
			'test'=>$rev->document_status_id
		));
	}*/
	
	/**
	 * 
	 * Function to update DocumentReceiver inline status
	 */
	public function actionUpdateReceiverStatus()
	{
		//if(Yii::app()->request->isAjaxRequest()){
			if($_POST['pk'])
			{
				$rev = DocumentReceiver::model()->findByPk($_POST['pk']);
				if($rev){
					$rev->document_status_id = $_POST['value'];
					$rev->status_date = date('d-m-Y H:i:s');
					$rev->save();
				}
			}
		//}
	}	
	
	/**
	 * Funtion to display inline documentReceiver status 
	 */
	public function getReceivers($id,$readonly=false){
		$Outdoc = OutDocument::model()->findByPk($id);
		$this->renderPartial('status_doc_receiver',array('receivers'=>$Outdoc,'readonly'=>$readonly));
	}
		
}