<?php 
echo'<b>'. Yii::t('app','In document of date').' '.date('m-d-Y').'</b>';
?>
<div class="row-fluid">
	<div class="span12">
		<?php 
		Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$.fn.yiiGridView.update('inc-document-grid', {
				data: $(this).serialize()
			});
			return false;
		});
		");
		?>
		<?php echo CHtml::link(Yii::t('app','Search by type document'),'#',array('class'=>'search-button btn ')); ?>
		<div class="search-form"  style="display:none">
		<?php $this->renderPartial('_search',array(
			'model'=>$model,
		)); ?>
		</div><!-- search-form -->
	</div>
</div>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'inc-document-grid',
	 'type'=>'striped',
	'dataProvider'=>$model->today()->indoc_of_me()->search(),
	//'filter'=>$model,
	'emptyText' => Yii::t('app','No results found.'),
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),
	'columns'=>array(
        array(
            'name'=>'inc_document_no',
            'header'=>Yii::t('app','Document #'),
        ),
        array(
            'class'=>'CLinkColumn',
            'labelExpression'=>'$data->is_application == "Yes" ? "Yes":""',
            'header'=>Yii::t('app','App?'),
            'urlExpression'=>'$data->is_application == "Yes" ? Yii::app()->createUrl("inDocument/checkApptype/",array("indocID"=>$data->document_id,"doctypeID"=>$data->document->document_type_id,)) : ""',
        ),
        array(
            'name'=>'document_from',
            'header'=>Yii::t('app','From'),
        ),
		'sender_ref',
         
        array(
            'name'=>'document_date',
            'header'=>Yii::t('app','Document Date'),
        ),
        array(
			'class' => 'bootstrap.widgets.TbEditableColumn',
			'name' => 'document_status_id',
        	'header'=>Yii::t('app','Status'),
			'sortable'=>false,
			'editable' => array(
        		'type'=> 'select',
                  'url'=>$this->createUrl('/inDocument/statusChange'),
                  'source'  =>CHtml::listData(DocumentStatus::model()->findAll('status_type="INC"'), 'id', 'status_description'),
			)
		),
        
        array(
            'name'=>'document_title',
            'header'=>Yii::t('app','Document Title'),
        ),
        array(
            'class'=>'CLinkColumn',
            'label'=>'<img alt="" src="'. Yii::app()->baseURL.'/images/clip.png">',
            'header'=>Yii::t('app','Attach file'),
        	'urlExpression'=>'Yii::app()->createUrl("attachFile/create",array("docid"=>$data->document_id))',
        ),
       /* array(
		        'filter'=>false,
		        'type'=>'raw',
				'value'=> 'CHtml::ajaxLink("'.Yii::t('app','Assign').'", array("assign/create/","docid"=>$data->document_id),  
							array(
									"success"=>"js:function(data){
									$(\".modal-body0\").html(data);
									$(\"#myModal0\").modal(\"show\");
									//return false;
								}"
								))',      
		),*/
        array(
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{Assign}',
		'buttons'=>array(
			'Assign'=>array(
				//'icon'=>'icon-dollar',
				'label'=>Yii::t('app','Assign'),
				'url'=>'Yii::app()->createUrl("assign/create/", array("docid"=>$data->document_id))',
				'options'=>array(
                            'ajax'=>array(
                                'type'=>'POST',
                                'url'=>"js:$(this).attr('href')",
                                'success'=>'function(data) { $("#myModal0 .modal-body0").html(data); $("#myModal0").modal(); }'
                            ),
	                        ),
				),
			)
		),
		
		 array(
        	'header'=>Yii::t('app','Assign'),
        	'type'=>'raw',
        	'value'=>'IncDocument::getAsign("$data->document_id")',
        ),
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view} {update}',
			'buttons'=>array(
               'view'=>array(
                     'url'=>'$this->grid->controller->createUrl("/inDocument/$data->primaryKey")',
                 ),
                'update'=>array(
                     'url'=>'$this->grid->controller->createUrl("/inDocument/update/$data->primaryKey")',
                ),
             )
		),
	),
)); ?>