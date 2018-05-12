<?php 
if($receivers)
		if($receivers->documentReceivers)
		{
			echo "<ul style='list-style-type: none; margin-left:-20px' >";
			foreach($receivers->documentReceivers as $aRec)
			{
				echo "<li><span class='span2'>".$aRec->receiver_name."(".$aRec->toOrganization->organization_code.")</span>";
				//$str.= $aRec->documentStatus->status_description;
				if($readonly){
					echo $aRec->documentStatus->status_description;
				}else{
					
					//$my = new TbEditableField();
					 $this->Widget('bootstrap.widgets.TbEditableField', array(
						   'type'      => 'select',
						   'model'     => $aRec,
						   'attribute' => 'document_status_id',
						   'url'       => Yii::app()->controller->createUrl('updateReceiverStatus'),  //url for submit data
						   'source'    => CHtml::listData(DocumentStatus::model()->findAll('status_type="OUT"'),'id', 'status_description'),
						));
				}
				echo "</li>";
			}
			echo "</ul>";
		}