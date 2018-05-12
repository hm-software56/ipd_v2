<?php 
echo'<b>'. Yii::t('app','Out document to me of date').'</b>';
?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'out-document-grid2',
	'dataProvider'=>$model_out_to_me,
	//'filter'=>$model,
	'emptyText' => Yii::t('app','No results found.'),
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),
	'columns'=>array(
		array(
            'name'=>'out_document_no',
            'header'=>Yii::t('app','Document #'),
        ),
        'document_title',
        array(
            'name'=>'documentType.description',
            'header'=>Yii::t('app','Document Type'),
        	'value'=>'$data->document->documentType->description'
        ),
	//	'document_id',
        array(
            'name'=>'document_date',
            'header'=>Yii::t('app','Date'),
        ),
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
        	'value'=>'$this->grid->controller->getReceivers("$data->document_id",true)',
        ),
         array(
        	'header'=>Yii::t('app','Clone'),
        	'type'=>'raw',
        	'value'=>'(!Yii::app()->user->checkAccess("DG"))?CHtml::Link(
        				Yii::t("app","Clone"),
        				Yii::app()->createUrl("/inDocument/cloneDocument",
        							array("out_document_id"=>$data->document_id))):""'
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view} (!Yii::app()->user->checkAccess("DG"))?{update}:""',
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