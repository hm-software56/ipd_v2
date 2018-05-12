<?php
$this->breadcrumbs=array(
	'Inc Documents'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List IncDocument','url'=>array('index')),
	array('label'=>'Create IncDocument','url'=>array('create')),
);

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

<h1>Manage Inc Documents</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'inc-document-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'document_id',
		'inc_document_no',
		'is_application',
		'sender',
		'sender_ref',
		'document_status_id',
		/*
		'status_date',
		'from_organization_id',
		'to_organization_id',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
