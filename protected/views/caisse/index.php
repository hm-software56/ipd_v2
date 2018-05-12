<?php
$this->layout="column1";
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('caisse-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'caisse-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'emptyText' => Yii::t('app','No results found.'),
'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s).'),
'columns'=>array(
		array(
			'name'=>'inc_document_no',
			'value'=>'$data->incDocument->inc_document_no'
		),
		'amount_to_budget',
		'amount_to_department',
		'create_date',
		'payment_date',
		
		array(
			'name'=>'payment_status',
			'value'=>'$data->payment_status==1?Yii::t(\'app\',\'Yes Payment\'):Yii::t(\'app\',\'No Payment\')',
		))
)); ?>