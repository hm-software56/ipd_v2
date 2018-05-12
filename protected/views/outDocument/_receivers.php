<?php 
$arrayReceivers =Yii::app()->user->getState('receivers');
if(count($arrayReceivers))
{
?>
<div>
<?php 
	$gridDataProvider= array();
		$i=0;
		foreach($arrayReceivers as $oneReiv)
		{
			$child =array();
			$child['idx']=$i++;
			$child['id']=$oneReiv->id;
			$child['name']= $oneReiv->receiver_name;
			$child['document_status'] = $oneReiv->documentStatus->status_description;
			$child['status_date'] = $oneReiv->status_date;
			$child['organization']= Organization::model()->findByPk($oneReiv->to_organization_id)->organization_name;
			$gridDataProvider[]=$child;
		}
		$gridDataProvider= new CArrayDataProvider($gridDataProvider);
		
//	print_r($gridDataProvider);
	
	
/*/	$gridDataProvider = new CArrayDataProvider(array(
    array('id'=>1, 'firstName'=>'Mark', 'lastName'=>'Otto', 'language'=>'CSS'),
    array('id'=>2, 'firstName'=>'Jacob', 'lastName'=>'Thornton', 'language'=>'JavaScript'),
    array('id'=>3, 'firstName'=>'Stu', 'lastName'=>'Dent', 'language'=>'HTML'),
));*/

	//print_r($gridDataProvider);
	$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'receiverslist-grid',
    'type'=>'striped bordered condensed',
    'dataProvider'=>$gridDataProvider,
	'emptyText' => Yii::t('app','No results found.'),
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s).'),
    'template'=>"{items}",
    'columns'=>array(
       // array('name'=>'idx', 'header'=>'#'),
        array('name'=>'name', 'header'=>Yii::t('app','Full Name')),
        array('name'=>'status_date','header'=>Yii::t('app','Status Date')),
        array('name'=>'document_status','header'=>Yii::t('app','Document Status')),
        array('name'=>'organization', 
        		'header'=>Yii::t('app','Organization'),
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        	'template'=>'{delete}',
			'buttons'=>array(
				'delete'=>array(
					//'label'=>'Remove this receiver',
					'url'=>'Yii::app()->controller->createUrl("delReceiver",array("idx"=>$data["idx"]))',
					'options' => array( 'ajax' => 
						array(
								'type' => 'POST', 
								'url'=>'js:$(this).attr("href")', 
								//'data'=>array("id"=>$data["id"]),
								'success' => "js:function(data) { 
										//$.fn.yiiGridView.update('receiverslist-grid');
										 $('#receivers').html(data);
										return false;
								}",
								//'update'=>'#receiverslist-grid',
						),
						"id"=>"corbeille".uniqID(),
						//'class'=>'icon-trash'
					)
				)
			)
        ),
    ),
)); 
?>
</div>
<?php 
}
?>