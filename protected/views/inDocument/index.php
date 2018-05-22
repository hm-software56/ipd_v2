<?php
$this->layout='column1';
?>
<?php 
$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'myModal','style'=>'width:800px'))); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><b><?php echo Yii::t('app','Document Assign To User')?></b></h4>
</div>
 
<div class="modal-body">
    <p>One fine body...</p>
</div>
<?php $this->endWidget(); ?>
<div class="row-fluid">
	<div class="span10">
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
	<div class="span2">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>Yii::t('app','New Incomming Document'),
		    'type'=>'info',
		    'url'=>array('create'),
		)); ?>
	</div>
</div>
<?php 
$controller = $this;
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'inc-document-grid',
	 'type'=>'condensed striped',
	'dataProvider'=>$model->indoc_of_me(1)->search(),
	'filter'=>$model,
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),
	'columns'=>array(
        array(
            'name'=>'inc_document_no',
            'header'=>Yii::t('app','Document #'),
        ),
        array(
            'class'=>'CLinkColumn',
            'labelExpression'=>'$data->is_application == "Yes" ? "Yes":""',
            'header'=>'App?',
            'urlExpression'=>'$data->is_application == "Yes" ? Yii::app()->createUrl("inDocument/checkApptype/",array("indocID"=>$data->document_id,"doctypeID"=>$data->document->document_type_id,)) : ""',
        	'visible'=>Yii::app()->user->checkAccess('SingleWindow')
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
        //'office_no',
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
			'type' => 'raw',
			//'value'=>'IncDocument::model()->addlink($data->document_title,$data->document_id)',
			'value' => function ($data, $row) use ($controller) {
				return $controller->renderPartial('modal_all_status', array('doc_id' => $data->document_id,'title'=> $data->document_title),false ,false);
			}
		),
         array(
        	'name'=> 'document_id',
        	//'value'=>'!empty(IncDocument::model()->findByPk($data->document->related_document_id)->inc_document_no)?IncDocument::model()->findByPk($data->document->related_document_id)->inc_document_no:""',
        	'value'=>'IncDocument::model()->getrelIncTosection($data->document->related_document_id)',
        	'header'=>Yii::t('app','In document no'),
         	//'filter'=>true,
        	'visible'=>!Yii::app()->user->checkAccess('SingleWindow')
        ),
        array(
            'class'=>'CLinkColumn',
            'label'=>'<img alt="" src="'. Yii::app()->baseURL.'/images/clip.png">',
            'header'=>Yii::t('app','Attach file'),
        	'urlExpression'=>'Yii::app()->createUrl("attachFile/create",array("docid"=>$data->document_id))',
        ),
        /*array(
		        'filter'=>false,
		        'type'=>'raw',
				'value'=> 'CHtml::ajaxLink("'.Yii::t('app','Assign').'", array("assign/create/","docid"=>$data->document_id),  
							array(
									"success"=>"js:function(data){
									$(\".modal-body\").html(data);
									$(\"#myModal\").modal(\"show\");
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
                                'success'=>'function(data) { $("#myModal .modal-body").html(data); $("#myModal").modal(); }'
                            ),
	                        ),
				),
			)
		),
			
		 array(
        	'name'=>'#',
        	'header'=>Yii::t('app','Assign'),
        	'type'=>'raw',
        	'value'=>'IncDocument::getAsign("$data->document_id")',
		 	'filter'=>false,
        ),
		array(
			'name'=>'#',
        	'header'=>Yii::t('app','DG'),
        	'type'=>'raw',
        	'value'=>'CommentToUser::getReadcomment("$data->document_id")',
		 	'filter'=>false,
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view} {update}',
		),
	),
)); ?>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">ສຳ​ລັບ​ນັກ​ລົງ​ທືນ​ທີ​ຕ້ອງ​ການ​ເບີງ​ເອ​ກະ​ສານ​ຕົນ​ເອງ</h3>
		</div>
		<div class="modal-body">
		</div>
</div>