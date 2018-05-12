<?php

Yii::import('application.models._base.BaseDocument');

class Document extends BaseDocument
{
	public $related_document_no;
	public $document_no;
	public $document_type;
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/** 
     * 
     * @ Param Criteria $ CDbCriteria 
     * @ Return CActiveDataProvider 
     */ 
    public function getDataProvider($criteria=null, $pagination=null) {
        if ((is_array ($criteria)) || ($criteria instanceof CDbCriteria) )
           $this->getDbCriteria()->mergeWith($criteria);
        $pagination = CMap:: mergeArray (array ('pageSize' => 10), (array) $pagination); 
        return new CActiveDataProvider(__CLASS__, array(
                        'criteria'=>$this->getDbCriteria(),
                        'pagination' => $pagination
        ));
    }
	/**
	 * This function is used to search a document by document title. 
	 * The function uses full text search technique to find relavant document
	 * @param string $keyword
	 * @return CArrayDataProvider
	 */
	public static function searchByTitle($keyword)
	{
	    $command = Yii::app()->db->createCommand();
	    $command->select("id,MATCH(document_title) AGAINST ('*".$keyword."*' IN BOOLEAN MODE) AS relevance");
	    $command->from('fulltext_document');
	    $command->where("MATCH(document_title) AGAINST ('*".$keyword."*' IN BOOLEAN MODE)");
	    $doc_ids=$command->queryAll();
	    
	    $documents=array();
	    foreach ($doc_ids as $key=>$value) {
	        $documents[]=Document::model()->findByPk($value['id']);
	    }
	    
	    return new CArrayDataProvider($documents);
	}

	public function scopes()
	{
		$today = date("Y-m-d");
		$userID = Yii::app()->user->id;
		return array(
			'today'=>array(
				'condition'=>"orderTimeStamp>='".$today."'",
				'order'=>'orderTimeStamp desc',
			),
			'perso'=>array(
				'condition'=>"created_by='".$userID."'",
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
	    if ($this->document_date != '' && $this->document_date != '0000-00-00')
	    {
	        $this->document_date = date('d-m-Y',strtotime($this->document_date));
	    }
	    
		if($this->relDocument)
	    {
	    	if($this->relDocument->in_or_out=="INC"){
	    		$this->related_document_no = $this->relDocument->incDocument->inc_document_no;
	    		//echo $document->related_document_no;exit;
	    	}
	    	else{
	    		$this->related_document_no = $this->relDocument->outDocument->out_document_no;
	    	}
	    }
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	public function beforeSave()
	{
	    if ($this->document_date != '' && $this->document_date != '0000-00-00')
	    {
	        $this->document_date = date('Y-m-d',strtotime($this->document_date));
	    }
	    return parent::beforeSave();
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
	 * @see CActiveRecord::afterDelete()
	 */
	public function afterDelete()
	{
	    parent::afterDelete();
	    FulltextDocument::model()->deleteAllByAttributes(array('id'=>$this->id));
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterSave()
	 */
	public function afterSave()
	{
	    parent::afterSave();
	    if ($this->isNewRecord) {
	        $fullText=new FulltextDocument;
	        $fullText->id=$this->id;
	        $fullText->document_title=$this->document_title;
	        $fullText->save();
	    } else {
	        if ($this->isAttributeChanged('document_title')) {
	            $fullText=FulltextDocument::model()->findByAttributes(array('id'=>$this->id));
	            if ($fullText != NULL) {
	                $fullText->document_title=$this->document_title;
	                $fullText->update(array('document_title'));
	            }
	        }
	    }
	}
	

	public function relations() {
		
		$newRelations=array(
	       'relDocument' => array(self::BELONGS_TO, 'Document', 'related_document_id'),
	    );
	    return array_merge(parent::relations(),$newRelations);
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
	            'document_type, document_no',
	            'safe',
	            'on'=>'search',
	        )
	    );
	    return array_merge($parent,$new);
	}

	public function search($pagination=null) {
		$criteria = new CDbCriteria;
		
		$criteria->with=array(
		    'documentType',
			'incDocument',
			'outDocument',
		);
		
		$mydate;
	 	if ($this->document_date != '' && $this->document_date != '0000-00-00')
	    {
	        $mydate = date('Y-m-d',strtotime($this->document_date));
	    }
	    
		$criteria->compare('t.id', $this->id, true);
		$criteria->compare('in_or_out', $this->in_or_out, true);
		$criteria->compare('document_date', $mydate, true);
		$criteria->compare('document_title', $this->document_title, true);
		$criteria->compare('related_document_id', $this->related_document_id);
		$criteria->addSearchCondition('inc_document_no', $this->document_no, true,"OR","LIKE");
		$criteria->addSearchCondition('out_document_no', $this->document_no, true, 'OR',"LIKE");
		$criteria->compare('documentType.description', $this->document_type, 'OR');
		$criteria->compare('document_type_id', $this->document_type_id);
		$criteria->compare('created', $this->created, true);
		$criteria->compare('created_by', $this->created_by);
		$criteria->compare('last_modified', $this->last_modified, true);
		$criteria->compare('last_modified_id', $this->last_modified_id);
		
		
		$pagination = CMap:: mergeArray (array ('pageSize' => 20), (array) $pagination);
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
		        'attributes'=>array(
		            'document_title'=>array(
		                'asc'=>'document_title',
		                'desc'=>'document_title DESC',
		            ),
		            'document_date'=>array(
		                'asc'=>'document_date',
		                'desc'=>'document_date DESC',
		            ),
		            'document_type'=>array(
		                'asc'=>'documentType.description',
		                'desc'=>'documentType.description DESC',
		            ),
		            '*',
		        ),
		        'defaultOrder'=>'t.id DESC',
		    ),
		    /*'pagination'=>array(
		        'pageSize'=>20,
		    )*/
		    'pagination' => $pagination
		));
	}
}