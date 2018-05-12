<?php Yii::app()->bootstrap->registerCoreCss(); ?>
<?php Yii::app()->bootstrap->registerCoreScripts(); ?>
<?php Yii::app()->bootstrap->registerYiiCss(); ?>

<?php 
$columns = array(
    //'company_name',
	array('name'=>'company_name',
		'header'=>Yii::t('app','Company name')
	),
    //register_place',
	array('name'=>'register_place',
		'header'=>Yii::t('app','Register place')
	),
    //'register_date',
	array('name'=>'register_date',
		'header'=>Yii::t('app','Register date')
	),
	//'total_capital',
	array('name'=>'total_capital',
		'header'=>Yii::t('app','Total capital')
	),
	//'capital',
    array('name'=>'capital',
		'header'=>Yii::t('app','Capital')
	),
    
    array(
        'class'=>'bootstrap.widgets.TbButtonColumn',
        'template'=>'{view}{delete}',
        'buttons'=>array(
            'view'=>array(
                'visible'=>'Yii::app()->controller->action->id=="view"',
                'url'=>'Yii::app()->controller->createUrl("viewInvestModal",array("id"=>$data->id))',
                'options'=>array(
                    'ajax'=>array(
                        'type'=>'POST',
                        'url'=>"js:$(this).attr('href')",
                        'success'=>'function(data) { $("#viewModal .modal-body p").html(data); $("#viewModal").modal(); }'
                    ),
                ),
            ),
            'delete'=>array(
                'url'=>'Yii::app()->controller->createUrl("removeInvest",array("company_name"=>$data->company_name))',
                'visible'=>'Yii::app()->controller->action->id!="view"',
            ),
        ),
    )
);
?>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'invest-grid',
    'type' => 'striped bordered condensed',
    'template'=>'{items}',
    'dataProvider' => $model->getInvestProvider(),
    'columns' => $columns,
));
?>

 <!-- View Popup  -->
<?php    
$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'viewModal')); ?>

<!-- Popup Header --> 
<div class="modal-header">
<h4>View Invest Company Details</h4>
</div>

<!-- Popup Content -->
<div class="modal-body">
<p>Employee Details</p>
</div>


<!-- Popup Footer -->
<div class="modal-footer">
<!-- close button -->
<?php $this->widget('bootstrap.widgets.TbButton', array(
'label'=>'Close',
'url'=>'#',
'htmlOptions'=>array('data-dismiss'=>'modal'),
)); ?>
<!-- close button ends-->
</div>
<?php $this->endWidget(); ?>
<!-- View Popup ends -->

