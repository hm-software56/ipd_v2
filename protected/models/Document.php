<?php

Yii::import('application.models._base.BaseDocument');

class Document extends BaseDocument
{
	public $related_document_no;
	public $document_no;
	public $document_type;
	public $start_date;
	public $end_date;
	
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
		$organizationID = UserProfile::model()->findByPk($userID)->organization_id;
		
		if(Yii::app()->user->checkAccess("DG"))
		{
			return array(
				'today'=>array(),
				'outdoc_to_me'=>array(),
				'outdoc_of_me'=>array(),
				'indoc_of_me'=>array(),
				'doc_of_my_organization'=>array(),
			);
		}
		
		return array(
			'today'=>array(
				'condition'=>"orderTimeStamp>='".$today."'",
				'order'=>'orderTimeStamp desc',
			),
			'outdoc_to_me'=>array(	// Documents from others sent to my dept
				'with'=>array('outDocument.documentReceivers'),
				'condition'=>"to_organization_id=".$organizationID."",
			),
			'outdoc_of_me'=>array(	// Documents out from my dept
				'with'=>array(
					'createdBy.userProfile'=>
						array(
							'condition'=>"organization_id='".$organizationID."' and in_or_out='OUT'",
						)
				)
			),
 			'indoc_of_me'=>array(	// Documents of my dept
				'with'=>array(
					'createdBy.userProfile'=>
						array(
							'condition'=>"organization_id='".$organizationID."' and in_or_out='INC'",
						)
				)
			),
			'doc_of_my_organization'=>array(	// Documents of my dept
				'with'=>array(
					'createdBy.userProfile'=>
						array(
							'condition'=>"organization_id='".$organizationID."'",
						)
				)
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
	    
	    if($this->last_modified  != '' && $this->last_modified != '0000-00-00 00:00:00')
	    {
	    	$this->last_modified = date('d-m-Y H:i:s',strtotime($this->last_modified));
	    }
		if($this->created!= '')
	    {
	    	$this->created = date('d-m-Y',strtotime($this->created));
	    }
	    
		if($this->relDocument)
		{
		   	if($this->relDocument->in_or_out=="INC")
		   		$this->related_document_no = $this->relDocument->incDocument->inc_document_no;
		   	else
		   		$this->related_document_no = $this->relDocument->outDocument->out_document_no;
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
		
	    $this->last_modified = date('Y-m-d H:i:s');
	    
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
	                //$fullText->update(array('document_title'=>$fullText->document_title));
	                $fullText->save();
	            }
	        }
	    }
		parent::afterSave();
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
	        ),
	        array('start_date,end_date','length', 'max'=>255),
	    );
	    return array_merge($parent,$new);
	}

	public function search($critere=null,$pagination=null) {	
		
		$criteria = new CDbCriteria;
		
		$criteria->with=array(
		    'documentType',
			'incDocument',
			'outDocument',
		);

		if($critere!=null)
		 {
                $criteria->mergeWith($critere);
		 }
		 
		$mydate="";
	 	if ($this->document_date != '' && $this->document_date != '0000-00-00')
	    {
	        $mydate = date('Y-m-d',strtotime($this->document_date));
	    }
		$criteria->compare('t.id', $this->id, true);
		$criteria->compare('in_or_out', $this->in_or_out, true);
		$criteria->compare('document_date', $mydate, true);
		$criteria->compare('document_title', $this->document_title, true);
		$criteria->compare('related_document_id', $this->related_document_id);
		if($this->in_or_out=="INC")
			$criteria->addSearchCondition('inc_document_no', $this->document_no, true,"AND","LIKE");
		elseif($this->in_or_out=="OUT") 
			$criteria->addSearchCondition('out_document_no', $this->document_no, true, 'AND',"LIKE");
			
		$criteria->compare('documentType.description', $this->document_type, 'OR');
		$criteria->compare('document_type_id', $this->document_type_id);
		$criteria->compare('created', $this->created, true);
		$criteria->compare('created_by', $this->created_by);
		$criteria->compare('last_modified', $this->last_modified, true);
		$criteria->compare('last_modified_id', $this->last_modified_id);
		$criteria->compare('detail', $this->detail, true);
		
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
	
	public function getshowrelate($cat_id, $relate_id, $level_string) {
        $select_str='';
        if(!$level_string)
              {
                  $level_string='';
              }
          $cat_arr =Document::findAll('related_document_id='.$cat_id.'',array('oder'=>'by t.id DESC' )) ;
        if (!is_object($cat_arr)) {
        	
            foreach ($cat_arr as $cat) {
               if($cat->in_or_out=="INC")
               {
            		$select_str.='<tr><td>'.$level_string. '<a href="' . Yii::app()->baseUrl . '/index.php/inDocument/'.$cat->id.'">'.$cat->incDocument->inc_document_no.'</a></td><td>'.$cat->incDocument->documentStatus->status_description.'</td><td>'.$cat->incDocument->fromOrganization->organization_name.'</td><td>'.$cat->incDocument->status_date.'</td></tr>';
               }else{
               		$receiver='';
               		$date='';
               		$org='';
               		$out=DocumentReceiver::model()->findAllByAttributes(array('out_document_id'=>$cat->id));
               		if(!is_object($out))
               		{
               			foreach ($out as $outs)
               			{
               				$receiver.=$outs->documentStatus->status_description.'<br/>';
               				$date.=date('d-m-Y',strtotime($outs->status_date)).'<br/>';
               				$org.=$outs->toOrganization->organization_name.'<br/>';
               			}
               		}
            		$select_str.='<tr><td>'.$level_string. '<a href="' . Yii::app()->baseUrl . '/index.php/outDocument/'.$cat->id.'">'.$cat->outDocument->out_document_no.'</a></td><td>'.$receiver.'</td><td>'.$org.'</td><td>'.$date.'</td></tr>';
               }                   
               $select_str.= $this->getshowrelate($cat->id, $relate_id, $level_string.'<b>&raquo;</b>');                              
            }  
          
        }
        else
        {
        	//$select_str1.='<tr><th colspan="3">fgfdgdg</th></tr>';
            return false;
          // return $select_str1;
        }
        return $select_str;
       
	}

	public function getshowrelatepublic($cat_id, $relate_id, $level_string)
	{
		$select_str = '';
		if (!$level_string) {
			$level_string = '';
		}
		$cat_arr = Document::findAll('related_document_id=' . $cat_id . '', array('oder' => 'by t.id DESC'));
		if (!is_object($cat_arr)) {

			foreach ($cat_arr as $cat) {
				if ($cat->in_or_out == "INC") {
					$select_str .= '<tr><td>' . $level_string . ' ' . $cat->incDocument->inc_document_no . '</td><td>' . $cat->incDocument->documentStatus->status_description . '</td><td>' . $cat->incDocument->fromOrganization->organization_name . '</td><td>' . $cat->incDocument->status_date . '</td></tr>';
				} else {
					$receiver = '';
					$date = '';
					$org = '';
					$out = DocumentReceiver::model()->findAllByAttributes(array('out_document_id' => $cat->id));
					if (!is_object($out)) {
						foreach ($out as $outs) {
							$receiver .= $outs->documentStatus->status_description . '<br/>';
							$date .= date('d-m-Y', strtotime($outs->status_date)) . '<br/>';
							$org .= $outs->toOrganization->organization_name . '<br/>';
						}
					}
					$select_str .= '<tr><td>' . $level_string . ' ' . $cat->outDocument->out_document_no . '</td><td>' . $receiver . '</td><td>' . $org . '</td><td>' . $date . '</td></tr>';
				}
				$select_str .= $this->getshowrelatepublic($cat->id, $relate_id, $level_string . '<b>&raquo;</b>');
			}

		} else {
        	//$select_str1.='<tr><th colspan="3">fgfdgdg</th></tr>';
			return false;
          // return $select_str1;
		}
		return $select_str;

	}

	public function getshowrelatestatus($cat_id, $relate_id, $level_string)
	{
		$select_str = '';
		if (!$level_string) {
			$level_string = '';
		}
		$cat_arr = Document::findAll('related_document_id=' . $cat_id . '', array('oder' => 'by t.id DESC'));
		if (!is_object($cat_arr)) {

			foreach ($cat_arr as $cat) {
				if ($cat->in_or_out == "INC") {
					$select_str .= '<tr><td>' . $level_string . ' ' . $cat->incDocument->inc_document_no . '</td><td>' . $cat->incDocument->documentStatus->status_description . '</td><td>' . $cat->incDocument->fromOrganization->organization_name . '</td><td>' . $cat->incDocument->status_date . '</td><td>' . $cat->incDocument->getAsignshowinallstatus($cat->id) . '</td></tr>';
				} else {
					$receiver = '';
					$date = '';
					$org = '';
					$receiver_name="";
					$out = DocumentReceiver::model()->findAllByAttributes(array('out_document_id' => $cat->id));
					if (!is_object($out)) {
						foreach ($out as $outs) {
							$receiver .= $outs->documentStatus->status_description . '<br/>';
							$date .= date('d-m-Y', strtotime($outs->status_date)) . '<br/>';
							$org .= $outs->toOrganization->organization_name . '<br/>';
							$receiver_name.= $outs->receiver_name."<br/>";
						}
					}
					$select_str .= '<tr><td>' . $level_string . ' ' . $cat->outDocument->out_document_no . '</td><td>' . $receiver . '</td><td>' . $org . '</td><td>' . $date . '</td><td>' . $receiver_name . '</td></tr>';
				}
				$select_str .= $this->getshowrelatestatus($cat->id, $relate_id, $level_string . '<b>&raquo;</b>');
			}

		} else {
        	//$select_str1.='<tr><th colspan="3">fgfdgdg</th></tr>';
			return false;
          // return $select_str1;
		}
		return $select_str;

	}

	public function getalldocrelated($cat_id, $relate_id, $level_string)
	{
		$select_str = '';
		if (!$level_string) {
			$level_string = '';
		}
		$cat_arr = Document::findAll('related_document_id=' . $cat_id . '', array('oder' => 'by t.id DESC'));
		if (!is_object($cat_arr)) {
			
			foreach ($cat_arr as $cat) {
				$style = null;
				if ($cat->id == $_GET['id']) {
					$style = "style='background:#F1F0F0;'";
				}
				if ($cat->in_or_out == "INC") {
					$select_str .= '<tr '.$style.'><td>' . $level_string . ' <a href="'.Yii::app()->baseUrl.'/index.php/inDocument/' . $cat->id . '">' . $cat->incDocument->inc_document_no . '</a></td><td>'. $cat->document_title . '</td><td>' . $cat->in_or_out . '</td><td>' . $cat->documentType->description . '</td><td>' . $cat->incDocument->documentStatus->status_description . '</td><td>' . $cat->incDocument->fromOrganization->organization_name . '</td><td>' . $cat->incDocument->status_date . '</td><td>' . $cat->incDocument->getAsignshowinallstatus($cat->id) . '</td></tr>';
				} else {
					$receiver = '';
					$date = '';
					$org = '';
					$receiver_name = "";
					$out = DocumentReceiver::model()->findAllByAttributes(array('out_document_id' => $cat->id));
					if (!is_object($out)) {
						foreach ($out as $outs) {
							$receiver .= $outs->documentStatus->status_description . '<br/>';
							$date .= date('d-m-Y', strtotime($outs->status_date)) . '<br/>';
							$org .= $outs->toOrganization->organization_name . '<br/>';
							$receiver_name .= $outs->receiver_name . "<br/>";
						}
					}
					$select_str .= '<tr '. $style .'><td>' . $level_string . ' <a href="' . Yii::app()->baseUrl . '/index.php/outDocument/' . $cat->id . '">' . $cat->outDocument->out_document_no . '</a></td><td>' . $cat->document_title . '</td><td>' . $cat->in_or_out . '</td><td>' . $cat->documentType->description . '</td><td>' . $receiver . '</td><td>' . $org . '</td><td>' . $date . '</td><td>' . $receiver_name . '</td></tr>';
				}
				$select_str .= $this->getalldocrelated($cat->id, $relate_id, $level_string . '<b>&raquo;</b>');
			}

		} else {
        	//$select_str1.='<tr><th colspan="3">fgfdgdg</th></tr>';
			return false;
          // return $select_str1;
		}
		return $select_str;

	}

	public function getall($cat_id, $relate_id, $level_string)
	{
		$select_str = '';
		if (!$level_string) {
			$level_string = '';
		}
		if(!empty($relate_id))
		{
			$cat_arr = Document::findAll('id=' . $relate_id . '', array('oder' => 'by t.id DESC'));
			if (!is_object($cat_arr)) {
				foreach ($cat_arr as $cat) {
					$style = null;
					if ($cat->id == $_GET['id']) {
						$style = "style='background:#F1F0F0;'";
					}
					if(!empty($cat->related_document_id))
					{
						$select_str .= $this->getall($cat->id, $cat->related_document_id, $level_string . '<b>&raquo;</b>');
					}else{
						$level_string = '';
						if ($cat->in_or_out == "INC") {
							$select_str .= '<tr>'.$style.'<td>' . $level_string . ' <a href="' . Yii::app()->baseUrl . '/index.php/inDocument/' . $cat->id . '">' . $cat->incDocument->inc_document_no . '</a></td><td>' . $cat->document_title . '</td><td>' . $cat->in_or_out . '</td><td>' . $cat->documentType->description . '</td><td>' . $cat->incDocument->documentStatus->status_description . '</td><td>' . $cat->incDocument->fromOrganization->organization_name . '</td><td>' . $cat->incDocument->status_date . '</td><td>' . $cat->incDocument->getAsignshowinallstatus($cat->id) . '</td></tr>';
						}else{
							$receiver = '';
							$date = '';
							$org = '';
							$receiver_name = "";
							$out = DocumentReceiver::model()->findAllByAttributes(array('out_document_id' => $cat->id));
							if (!is_object($out)) {
								foreach ($out as $outs) {
									$receiver .= $outs->documentStatus->status_description . '<br/>';
									$date .= date('d-m-Y', strtotime($outs->status_date)) . '<br/>';
									$org .= $outs->toOrganization->organization_name . '<br/>';
									$receiver_name .= $outs->receiver_name . "<br/>";
								}
							}
							$select_str .= '<tr>'.$style.'<td>' . $level_string . ' <a href="' . Yii::app()->baseUrl . '/index.php/outDocument/' . $cat->id . '">' . $cat->outDocument->out_document_no . '</a></td><td>' . $cat->document_title . '</td><td>' . $cat->in_or_out . '</td><td>' . $cat->documentType->description . '</td><td>' . $receiver . '</td><td>' . $org . '</td><td>' . $date . '</td><td>' . $receiver_name . '</td></tr>';
				
						}
						$select_str .= $this->getalldocrelated($cat->id, $cat->related_document_id, $level_string . '<b>&raquo;</b>');
					}
				}

			} else {
				return false;
			}
		}else{
			$select_str .= $this->getalldocrelated($cat_id, $relate_id, $level_string);
		}
		return $select_str;
	}


}