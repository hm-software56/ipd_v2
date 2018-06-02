<?php

Yii::import('application.models._base.BaseIncDocument');

class IncDocument extends BaseIncDocument
{
    public $document_title;
    public $document_no;
    public $document_date;
    public $document_status;
    public $document_from;
    public $document_type_id;
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
	    $this->documentStatus=new DocumentStatus;
	    $this->status_date = date('d-m-Y');
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
	    $status=null;
	    
	    $document=$this->document;
	    //Call afterfind because it's not call this funtion from relation
	    $document->afterFind();
		
	    $this->document_title=$document->document_title;
	    $this->document_date=$document->document_date;
		
	    $documentType = ($document != null) ? $document->documentType : null;
	    $typeLevel = ($documentType != null) ? $documentType->typeLevel : null;
	    $status=$this->documentStatus;
	    $this->document_status=$status->status_description;
	    
	    if ($this->status_date != '' && $this->status_date != '0000-00-00') {
	        $this->status_date = date('d-m-Y', strtotime($this->status_date));
	    }
	       // $this->created = date('d-m-Y', strtotime($this->document->created));
	       // echo $this->document->created; exit;
	   
	    
	    $from=$this->fromOrganization;
	    $this->document_from=$from->organization_code;
	    
	    $this->document_no=$this->inc_document_no;
	    
	}
	
	/**
	 * (non-PHPdoc)
	 * @see BaseIncDocument::attributeLabels()
	 */
	public function attributeLabels()
	{
	    $label = array(
	        'document_no'=>Yii::t('appform','Document No'),
	    );
	    return array_merge(parent::attributeLabels(),$label);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CModel::afterValidate()
	 */
	public function afterValidate()
	{
	    parent::afterValidate();
	    //todo
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	public function beforeSave()
	{
	    if ($this->status_date != '' && $this->status_date != '0000-00-00') {
	        $this->status_date = date('Y-m-d', strtotime($this->status_date));
	    }
	    
	    /* Save histrory of incomming document */
	    if(!$this->isNewRecord)
	    {
		    $incHistory=new IncDocumentHistory;
		    $incdocument=IncDocument::model()->findByPK($this->document_id);
		    $incdocument->document=Document::model()->findByPK($this->document_id);
		    $incHistory->attributes=$incdocument->attributes;
		    $incHistory->attributes=$incdocument->document->attributes;
		    $incHistory->user_action_id=Yii::app()->user->id;
		    $incHistory->action_time=date('Y-m-d H:i:s');
		    $incHistory->save();
	    }
	    return parent::beforeSave();
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
                $sql = 'SELECT getNextCustomSeq("IncDoc","I","' . $code .'") AS document_no';
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $row = $command->queryRow();
                $this->inc_document_no=$row['document_no'];
                $this->document_no=$this->inc_document_no;
            }
	    }
	    return parent::beforeValidate();
	}
	
	/**
	 * Define a uniform methods for convenien using
	 */
	public function getDocumentNumber()
	{
	    return $this->inc_document_no;
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
	            'document_title, document_type_id, document_date, created, document_status,document_from',
	            'safe',
	            'on'=>'search',
	        )
	    );
	    return array_merge($parent,$new);
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
					'condition'=>"created>='".$today."'",
					'order'=>'created desc',
			),
			'indoc_of_me'=>array(
				'with'=>array(
					'document.createdBy.userProfile'=>
						array(
							'condition'=>"organization_id='".$organizationID."'",
						)
				)
			),
		);
	}
 
	/**
	 * (non-PHPdoc)
	 * @see BaseIncDocument::search()
	 */
	public function search()
	{
		//echo "exit";exit;
	    //Get user id and organization id
	    $user=Yii::app()->session->get('user');
	    if ($user===null)
	        throw new CHttpException(401, Yii::t('app','Please login'));

		$criteria = new CDbCriteria;
		$criteria->with=array(
		    'document',
		    'documentStatus',
		    'fromOrganization',
		);
		
		//Only Incoming Documents of the user group and child groups
		$condition=Organization::getChildCondition($user->organization_id);
		$condition = ($condition != "") ? "to_organization_id IN (" . $condition . ")" : "";
		$criteria->addCondition($condition);
		//print_r(Yii::app()->session['doc_id']);exit;
		if(!empty(Yii::app()->session['doc_id']))
		{
			$criteria->addInCondition('document_id', Yii::app()->session['doc_id']);
		}else{
			$criteria->compare('document_id', $this->document_id);
		}
		if(!empty(Yii::app()->session['userid_groud_org']) && Yii::app()->user->checkAccess('DG'))
		{
			$criteria->addInCondition('document.created_by', Yii::app()->session['userid_groud_org']);
		}
		$criteria->compare('inc_document_no', $this->inc_document_no, true);
		$criteria->compare('is_application', $this->is_application, true);
		$criteria->compare('sender', $this->sender, true);
		$criteria->compare('sender_ref', $this->sender_ref, true);
		$criteria->compare('document_status_id', $this->document_status_id);
		$criteria->compare('document.document_type_id', $this->document_type_id);
		$criteria->compare('status_date', $this->status_date, true);
		$criteria->compare('from_organization_id', $this->from_organization_id);
		$criteria->compare('to_organization_id', $this->to_organization_id);
		$criteria->compare('document.document_title', $this->document_title,true);
		$criteria->compare('document.document_date', $this->document_date,true);
		$criteria->compare('document.created', $this->created,true);
		$criteria->compare('office_no', $this->office_no, true);
		$criteria->compare('documentStatus.status_description',$this->document_status,true);
		$criteria->compare('fromOrganization.organization_code',$this->document_from,true);
		
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
		            'document_status'=>array(
		                'asc'=>'documentStatus.status_description',
		                'desc'=>'documentStatus.status_description DESC',
		            ),
		            'document_from'=>array(
		                'asc'=>'fromOrganization.organization_code',
		                'desc'=>'fromOrganization.organization_code DESC',
		            ),
		            '*',
		        ),
		        'defaultOrder'=>'document_id DESC',
		    ),
		    'pagination'=>array(
		        'pageSize'=>20,
		    )
		));	
	}
	
	public static function getAsign($id){
		$str="";
		$Assign= Assign::model()->findAll('inc_document_document_id='.$id.'');
		if(!is_object($Assign))
		{
			$str.="<ul style='list-style-type: none; margin-left:-20px' >";
			foreach($Assign as $Assigns)
			{
				$str.="<li><span class='span1'>".$Assigns->user->userProfile->first_name."</span></li>";
			}
			$str.="</ul>";
		}
		return $str;
	}

	public static function getAsignshowinallstatus($id)
	{
		$str = "";
		$Assign = Assign::model()->findAll('inc_document_document_id=' . $id . '');
		if (!is_object($Assign)) {
			foreach ($Assign as $Assigns) {
				$str .= $Assigns->user->userProfile->first_name . "<br/>";
			}
		}
		return $str;
	}
	
	public static function getrelInc($id)
	{
		$relate=IncDocument::model()->findByPk($id);
		if(!empty($relate))
		{
			echo $relate->inc_document_no;
		}
	}
	
	public static function getrelIncTosection($id)
	{
		//$relate=IncDocument::model()->findByPk($id);
		$out=OutDocument::model()->findByPk($id);
		if(!empty($out))
		{
			$Inc=IncDocument::model()->findByPk($out->document->related_document_id);
			if(!empty($Inc))
			{
				echo $Inc->inc_document_no;
			}
		}
	}
}
