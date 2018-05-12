<?php

Yii::import('application.models._base.BaseOutDocument');

class OutDocument extends BaseOutDocument
{
	public $document_title;
    public $document_no;
    public $document_date;
    public $document_type_id;
    public $receivers = NULL;
    public $documentType = NULL;
    public $created;
	
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
	    $this->document=new Document;
	    $this->document->documentType=new DocumentType;
	    $this->document->documentType->typeLevel=new TypeLevel;
	    //$this->receivers = array();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CModel::behaviors()
	 */
	public function behaviors()
	{
	    return array(
	        'TrackChangeBehavior' => array(
	            'class' => 'TrackChangeBehavior',
	        ),
	    );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterFind()
	 */
	public function afterFind()
	{
	    parent::afterFind();
	    $document=null;
	    $documentType=null;
	    $typeLevel=null;
	    $this->receivers = array();
	    
	    $document=$this->document;
	    //Call afterfind because it's not call this funtion from relation
	    $document->afterFind();
	    
	    if($document->relDocument)
	    {
	    	if($document->relDocument->in_or_out=="INC")
	    		$document->related_document_no = $document->relDocument->incDocument->inc_document_no;
	    	else
	    		$document->related_document_no = $document->relDocument->outDocument->out_document_no;
	    }
	    
	    $this->document_title=$document->document_title;
	    $this->document_date=$document->document_date;
	    
	    $documentType = ($document != null) ? $document->documentType : null;
	    $typeLevel = ($documentType != null) ? $documentType->typeLevel : null;
	    //$status=$this->documentStatus;
	    //$this->document_status=$status->status_description;
		$this->receivers = ($this->documentReceivers)?$this->documentReceivers:array();
	    $this->document_no=$this->out_document_no;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterSave()
	 */
	public function afterSave()
	{
	    if(parent::afterSave())
	    {
	    	if (!$this->isNewRecord) {
	            $outHistory = new OutDocumentHistory();
	            	            
	            $outHistory->attributes = $this->oldAttributes;
	            $outHistory->attributes = $this->document->oldAttributes;
	           
	            
	            $outHistory->user_action_id = Yii::app()->user->id;
	            $outHistory->action_time = date('Y-m-d H:i:s');
	            
	            //print_r($outHistory->attributes);exit;
	            $outHistory->save();
	     		/*
	            foreach($this->documentReceivers as $oldrev)
	            {
	            	$rev_history = new DocumentReceiverHistory;
	            	$rev_history->attributes = $oldrev->oldAttributes;
	            	$rev_history->user_action_id = Yii::app()->user->id;
	            	$rev_history->action_time = date('Y-m-d H:i:s');
	            	$rev_history->save();
	            }*/
	    	}
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CModel::beforeValidate()
	 */
	public function beforeValidate()
	{
	    if ($this->isNewRecord) {
            $user = Yii::app()->session->get('user');
            if ($user != NULL) {
                $code = $user->userProfile->organization->organization_code;
                $sql = 'SELECT getNextCustomSeq("OutDoc","O","' . $code .'") AS document_no';
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $row = $command->queryRow();
                $this->out_document_no=$row['document_no'];
                $this->document_no=$this->out_document_no;
            }
	    }
	    return parent::beforeValidate();
	}
	
	/**
	 * Define a uniform methods for convenien using
	 */
	public function getDocumentNumber()
	{
	    return $this->out_document_no;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::scopes()
	 */
	public function scopes()
	{
		$today = date("Y-m-d");
		$userID = Yii::app()->user->id;
		$organizationID = UserProfile::model()->findByPk($userID)->organization_id;
		
		return array(
			'today'=>array(
				'with'=>array(
					'document'=>array(
						'condition'=>"created>='".$today."'",
						'order'=>'created desc',
					)
				)
			),
			'outdoc_to_me'=>array(
				'with'=>array(
					'documentReceivers'=>
						array(
							'condition'=>"documentReceivers.to_organization_id='".$organizationID."'",
						)
				)
			),
			'outdoc_of_me'=>array(
				'with'=>array(
					'document.createdBy.userProfile'=>
						array(
							'condition'=>"userProfile.organization_id='".$organizationID."'",
						)
				)
			),
		);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see BaseIncDocument::rules()
	 */
	public function rules()
	{
	    $parent=parent::rules();
	    $new=array(
	        array(
	            'document_title,document_type_id,created',
	            'safe',
	            'on'=>'search',
	        )
	    );
	    return array_merge($parent,$new);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see BaseOutDocument::relations()
	 */
	public function relations() {
		
		$new = array(
		);
		return array_merge(parent::relations(),$new);
	}
	
	public static function getReceivers($documentID)
	{
		if($documentID!="")
		{
			$str=Null;
			$receivers = DocumentReceiver::model()->findAll("out_document_id=$documentID");
			if($receivers)
			{
				//$str=Null;
				foreach ($receivers as $r)
				{
					$str .= $r->receiver_name."(".$r->toOrganization->organization_code.")  $r->documentStatus<br>";
				}
			}
			return $str;
		}
	}
	/**
	 * (non-PHPdoc)
	 * @see BaseOutDocument::search()
	 */
	public function search($critere=null,$pagination=null){
		
		$criteria = new CDbCriteria;
		$criteria->with=array(
		    'document',
			'document.documentType'
//		    'documentReceivers',
		);
		$tmp_date = '';
		if($this->created!= '')
		{
		   $tmp_date = date('Y-m-d',strtotime($this->created));
		 }
		$criteria->compare('document_id', $this->document_id);
		$criteria->compare('out_document_no', $this->out_document_no, true);
		$criteria->compare('document.document_title', $this->document_title,true);
		$criteria->compare('document.document_type_id', $this->document_type_id);
		$criteria->compare('document.created', $tmp_date,true);
		$criteria->compare('document.document_date', $this->document_date,true);
		
		$pagination = CMap:: mergeArray (array ('pageSize' => 30), (array) $pagination);
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
		        'attributes'=>array(
		            'document_title'=>array(
		                'asc'=>'document.document_title',
		                'desc'=>'document.document_title DESC',
		            ),
		            'document_date'=>array(
		                'asc'=>'document.document_date',
		                'desc'=>'document.document_date DESC',
		            ),
		            'documentType.description'=>array(
			                'asc'=>'documentType.description',
			                'desc'=>'documentType.description DESC',
			        ),
		            '*',
		        ),
		        'defaultOrder'=>'document_id DESC',
		    ),
		    'pagination'=>$pagination
		));
	}
	
}