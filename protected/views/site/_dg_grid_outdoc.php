<?php 
echo'<b>'. Yii::t('app','Out document of date').'</b>';
?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'out-document-grid1',
	'dataProvider'=>$modelout->search(NULL,array('pageSize'=>'10')),
	'filter'=>$modelout,
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
            'name'=>'document_type_id',
            'header'=>Yii::t('app','Document Type'),
        	'value'=>'$data->document->documentType->description',
        	'filter'=>CHtml::listData(DocumentType::model()->findAll(), 'id', 'description'),
        ),
        
        array(
            'name'=>'created',
            'header'=>Yii::t('app','Created'),
        	'value'=>'$data->document->created',
        ),
        
        array(
        	'header'=>Yii::t('app','Send to'),
        	'type'=>'raw',
        	'value'=>'$this->grid->controller->getReceivers("$data->document_id",true)',
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}',
			'buttons'=>array(
               'view'=>array(
                     'url'=>'$this->grid->controller->createUrl("/outDocument/$data->primaryKey")',
                ),
             )
		),
	),
)); ?>