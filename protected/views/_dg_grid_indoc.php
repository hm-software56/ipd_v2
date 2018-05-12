<?php 
$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'myModal1','style'=>'width:800px'))); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><b><?php echo Yii::t('app','')?></b></h4>
</div>
 
<div class="modal-body1">
    <p>One fine body...</p>
</div>
<?php $this->endWidget(); ?>


<?php 
echo'<b>'. Yii::t('app','In document of date').'</b>';
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
	'dataProvider'=>$model->search(NULL,array('pageSize'=>'10')),
	'filter'=>$model,
	'emptyText' => Yii::t('app','No results found.'),
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),
	'columns'=>array(
        array(
            'name'=>'inc_document_no',
            'header'=>Yii::t('app','Document #'),
        ),
        array(
            'name'=>'is_application',
        	 'type'=>'raw',
            'header'=>Yii::t('app','App?'),
        	'value'=>'$data->is_application == "Yes" ? CHtml::ajaxLink("Yes", array("site/showrelate/","docid"=>$data->document_id),  
							array(
									"success"=>"js:function(data){
									$(\".modal-body1\").html(data);
									$(\"#myModal1\").modal(\"show\");
									//return false;
								}"
								)):""',
        	'filter'=>CHtml::dropDownList('IncDocument[is_application]','', 
              array('Yes' => 'Yes', 'No' => 'No'),
              array('empty' => '')
             )
        ),
       /* array(
        		'header'=>Yii::t('app','Document#'),
        		'name'=>'document_no',
		        'type'=>'raw',
        		'value'=>'CHtml::ajaxLink("$data->document_no", array("site/showrelate/","docid"=>$data->document_id),  
							array(
									"success"=>"js:function(data){
									$(\".modal-body1\").html(data);
									$(\"#myModal1\").modal(\"show\");
									//return false;
								}"
								))',   
		),*/
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
            'name'=>'document_status',
            'header'=>Yii::t('app','Status'),
        ),
        
        array(
            'name'=>'document_title',
            'header'=>Yii::t('app','Document Title'),
        ),
		array(
        	'header'=>Yii::t('app','Assign'),
        	'type'=>'raw',
        	'value'=>'IncDocument::getAsign("$data->document_id")',
        ),
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}',
			'buttons'=>array(
               'view'=>array(
                     'url'=>'$this->grid->controller->createUrl("/inDocument/$data->primaryKey")',
                 ),
             )
		),
	),
)); ?>