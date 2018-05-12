<?php
$this->layout='column1';
$this->breadcrumbs=array(
	'Out Documents'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List OutDocument','url'=>array('index')),
	array('label'=>'Create OutDocument','url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('out-document-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Out Documents</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>Yii::t('app','New Outgoing Document'),
    'type'=>'primary',
    'url'=>array('create'),
)); ?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'out-document-grid',
	'dataProvider'=>$model->outdoc_of_me()->search(),
	//'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'out_document_no',
            'header'=>'Document #',
        ),
        'document_title',
                array(
            'name'=>'documentType.description',
            'header'=>'Document Type',
        	'value'=>'$data->document->documentType->description'
        ),
	//	'document_id',
        array(
            'name'=>'document_date',
            'header'=>'Date',
        ),
        array(
            'class'=>'CLinkColumn',
            //'label'=>'<img alt="" src="/images/clip.png">',
           // 'label'=>CHtml::image('/ipdtracking/images/clip.png'),
            'label'=>'<img alt="" src="'. Yii::app()->baseURL.'/images/clip.png">',
            'header'=>'Attach file',
        	'urlExpression'=>'Yii::app()->createUrl("attachFile/create",array("docid"=>$data->document_id))',
        ),
        array(
        	'name'=>'#',
        	'header'=>'Send to',
        	'type'=>'raw',
        	'value'=>'OutDocument::getReceivers("$data->document_id")',
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
