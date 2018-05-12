<?php 
echo'<b>'. Yii::t('app','Out document of date').' '.date('m-d-Y').'</b>';
?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'out-document-grid1',
	'dataProvider'=>$modelout->today()->outdoc_of_me()->search(),
	//'filter'=>$model,
	'emptyText' => Yii::t('app','No results found.'),
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),
	'columns'=>array(
		array(
            'name'=>'out_document_no',
            'header'=>Yii::t('app','Document #'),
        ),
        array(
            'name'=>'document_title',
            'header'=>Yii::t('app','Document Title'),
        ),
        array(
            'name'=>'document_date',
            'header'=>Yii::t('app','Document Date'),
        ),
        array(
            'name'=>'documentType.description',
            'header'=>Yii::t('app','Document Type'),
        	'value'=>'$data->document->documentType->description'
        ),
	//	'document_id',
        
        array(
            'class'=>'CLinkColumn',
            //'label'=>'<img alt="" src="/images/clip.png">',
           // 'label'=>CHtml::image('/ipdtracking/images/clip.png'),
            'label'=>'<img alt="" src="'. Yii::app()->baseURL.'/images/clip.png">',
            'header'=>Yii::t('app','Attach file'),
        	'urlExpression'=>'Yii::app()->createUrl("attachFile/create",array("docid"=>$data->document_id))',
        ),
        array(
        	'header'=>Yii::t('app','Send to'),
        	'type'=>'raw',
        	//'value'=>'OutDocument::getReceivers("$data->document_id")',
        	'value'=>'$this->grid->controller->getReceivers($data->document_id)',
        	
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view} {update}',
			'buttons'=>array(
               'view'=>array(
                     'url'=>'$this->grid->controller->createUrl("/outDocument/$data->primaryKey")',
                ),
                'update'=>array(
                     'url'=>'$this->grid->controller->createUrl("/outDocument/update/$data->primaryKey")',
                ),
             )
		),
	),
)); ?>