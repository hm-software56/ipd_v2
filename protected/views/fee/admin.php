<?php
$this->breadcrumbs=array(
	'ຄ່າທໍານຽມ'=>array('index'),
	'ລາຍການຄ່າທໍານຽມ',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('fee-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'fee-grid',
'dataProvider'=>$model->search(),
'emptyText' => Yii::t('app','No results found.'),
'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),
'filter'=>$model,
'columns'=>array(
		'id',
		'fee_description',
		'amount_to_budget',
		'amount_to_department',
		'fee_type',
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
'template'=>'{update} {delete}',
),
),
)); ?>
