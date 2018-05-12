<?php 
$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'myModal','style'=>'width:800px'))); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><b><?php echo Yii::t('app','Change username and password')?></b></h4>
</div>
 
<div class="modal-body">
    <p>One fine body...</p>
</div>
<?php $this->endWidget(); ?>

<?php
$this->layout='column1';
/*$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);*/

$this->menu=array(
	array('label'=>'List User','url'=>array('index')),
	array('label'=>'Create User','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),
	'columns'=>array(
		array(
			'name'=>'first_name',
			'value'=>'$data->userProfile->first_name',
			'header'=>Yii::t('app','First Name'),
		),
		array(
			'name'=>'last_name',
			'value'=>'$data->userProfile->last_name',
			'header'=>Yii::t('app','Last Name'),
		),
       // 'username',
		array(
			'name'=>'organization_name',
			'value'=>'$data->userProfile->organization->organization_name',
			'header'=>Yii::t('app','Organization Name'),
			'filter'=>CHtml::activeDropDownList($model, 'organization_name',CHtml::listData(Organization::model()->findAll(), 'organization_name', 'organization_name'),array('empty'=>'------------------------')),
		),
		array(
			'name'=>'#',
        	'header'=>Yii::t('app','Rule'),
        	'type'=>'raw',
        	'value'=>'User::getshowrule("$data->id")',
		 	'filter'=>false,
		),
		array(
			'name'=>'status',
			'value'=>'$data->status',
			'filter'=>CHtml::activeDropDownList($model, 'status',Utils::enumItem($model, 'status'),array('empty'=>'----------')),
		),
		
		array(
		'class'=>'bootstrap.widgets.TbButtonColumn',
		'template'=>'{Assign}',
		'buttons'=>array(
			'Assign'=>array(
				//'icon'=>'icon-dollar',
				'label'=>Yii::t('app','Change password'),
				'url'=>'Yii::app()->createUrl("user/adminchangepassword/", array("id"=>$data->id))',
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
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update} {delete}',
		),
	),
)); ?>
