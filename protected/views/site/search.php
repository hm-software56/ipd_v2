<?php 
$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'myModal0','style'=>'width:800px'))); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><b><?php echo Yii::t('app','Document Assign to User')?></b></h4>
</div>
 
<div class="modal-body0" style="margin-left:5px">
    <p>One fine body...</p>
</div>
<?php $this->endWidget(); ?>
<?php 
$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'myModal','style'=>'width:800px'))); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><?php echo Yii::t('app','Update Receiver Document')?></h4>
</div>
 
<div class="modal-body">
    <p>One fine body...</p>
</div>
 
<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Save changes',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal',
        	'onClick'=>"$.ajax({
        		type:'POST',
        		dataType: 'json',
        		update : 'out-document-grid',
        		url: '".Yii::app()->createUrl('/outDocument/updateStatus')."',
        		data: 'receiverid='+$(\"#DocumentReceiver_id\").val()+
        			  '&document_status_id='+$(\"#DocumentReceiver_document_status_id\").val()+
        			  '&docNo=".$docNo."'
        		,
        		success:function(data){
        			if(data.result == 'success')
        				if(data.docNo){
        					window.location.replace(\"?docNo=\"+data.docNo);
        				}
        				//location.reload();
        				//$.fn.yiiGridView.update('out-document-grid1');
        				//$.fn.yiiGridView.update('out-document-grid2');
        		}		
        	});
        "),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>	
</div>
 
<?php $this->endWidget(); ?>

<h3><?php echo Yii::t('app','Search Results')?></h3>

<h3><?php echo Yii::t('app','Incomming Documents:')?></h3>
<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'inc_document_list',
	 'type'=>'striped',
	'dataProvider'=>$in_docs,
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
            'header'=>'App?',
           'urlExpression'=>'$data->is_application == "Yes" ? (Yii::app()->user->checkAccess("DG"))?"": Yii::app()->createUrl("inDocument/checkApptype/",array("indocID"=>$data->document_id,"doctypeID"=>$data->document->document_type_id,)) : ""',
        ),
        array(
            'name'=>'document_from',
            'header'=>Yii::t('app','From'),
        ),
        array(
        	'name'=>'sender_ref',
        	'header'=>Yii::t('app','Sender Ref'),
        ),
        array(
        	'name'=>'#',
        	'header'=>Yii::t('app','Status'),
        	'type'=>'raw',
        	'value'=>'Yii::app()->getController()->getStatusIndoc("$data->document_id")',
        ),
		
        array(
            'name'=>'document_date',
            'header'=>Yii::t('app','Date'),
        ),
        array(
        	'name'=>'document_title',
        	'header'=>Yii::t('app','Document Title'),
        ),
        array(
            'class'=>'CLinkColumn',
            'label'=>(Yii::app()->user->checkAccess("DG"))?'':'<img alt="" src="'. Yii::app()->baseURL.'/images/clip.png">',
            'header'=>Yii::t('app','Attach file'),
        	'urlExpression'=>(Yii::app()->user->checkAccess("DG"))?'':'Yii::app()->createUrl("attachFile/create",array("docid"=>$data->document_id))',
        ),
        array(
		    'filter'=>false,
		    'type'=>'raw',
			'value'=> '(Yii::app()->user->checkAccess("DG"))?"":CHtml::ajaxLink("'.Yii::t('app','Assign').'", array("assign/create/","docid"=>$data->document_id),  
						array(
								"success"=>"js:function(data){
								$(\".modal-body0\").html(data);
								$(\"#myModal0\").modal(\"show\");
								//return false;
						}"
				))',      
		),
		array(
        	'name'=>'#',
        	'header'=>Yii::t('app','Assign'),
        	'type'=>'raw',
        	'value'=>'IncDocument::getAsign("$data->document_id")',
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
			'template'=>(Yii::app()->user->checkAccess("DG"))?"{view}":"{view}{update}",
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

<h3><?php echo Yii::t('app','Outgoing Documents:')?></h3>
<?php 

$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'out-document-grid1',
	'dataProvider'=>$out_docs,
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
            'label'=>(Yii::app()->user->checkAccess("DG"))?'':'<img alt="" src="'. Yii::app()->baseURL.'/images/clip.png">',
            'header'=>Yii::t('app','Attach file'),
        	'urlExpression'=>'Yii::app()->createUrl("attachFile/create",array("docid"=>$data->document_id))',
        ),
        array(
        	'name'=>'#',
        	'header'=>Yii::t('app','Send to'),
        	'type'=>'raw',
        	'value'=>'(Yii::app()->user->checkAccess("DG"))?$this->grid->controller->getReceivers("$data->document_id",true):$this->grid->controller->getReceivers("$data->document_id")',
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
			'template'=>(Yii::app()->user->checkAccess("DG"))?'{view}':'{view} {update}',
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

<h3><?php echo Yii::t('app','Documents from Others:')?></h3>
<?php 

$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'out-document-grid2',
	'dataProvider'=>$out_docs_to_me,
	'emptyText' => Yii::t('app','No results found.'),
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),
	//'filter'=>$model,
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
            'label'=>(Yii::app()->user->checkAccess("DG"))?'':'<img alt="" src="'. Yii::app()->baseURL.'/images/clip.png">',
            'header'=>Yii::t('app','Attach file'),
        	'urlExpression'=>(Yii::app()->user->checkAccess("DG"))?'':'Yii::app()->createUrl("attachFile/create",array("docid"=>$data->document_id))',
        ),
        array(
        	'name'=>'#',
        	'header'=>Yii::t('app','Send to'),
        	'type'=>'raw',
        	'value'=>'$this->grid->controller->getReceivers("$data->document_id",true)',
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
			'template'=>(Yii::app()->user->checkAccess("DG"))?'{view}':'{view} {update}',
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
