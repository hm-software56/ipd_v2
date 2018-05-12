<?php Yii::app()->bootstrap->registerCoreCss(); ?>
<?php Yii::app()->bootstrap->registerCoreScripts(); ?>
<?php Yii::app()->bootstrap->registerYiiCss(); ?>

<?php 
$columns = array(
    array(
        'name'=>'province_id',
        'value'=>'isset($data->province)?$data->province:null',
        'header'=>Yii::t('app','Province'),
    ),
    array(
        'name'=>'district_id',
        'value'=>'isset($data->district)?$data->district:null',
        'header'=>Yii::t('app','District'),
    ),
    array(
        'name'=>'village_id',
        'value'=>'$data->village_id!=""?Village::model()->findByPk($data->village_id)->village_name:null',
        'header'=>Yii::t('app','Village'),
    ),
    array(
        'class'=>'bootstrap.widgets.TbButtonColumn',
        'template'=>'{delete}',
        'deleteButtonUrl'=>'Yii::app()->controller->createUrl("removeSite",array("province_id"=>$data->province_id,"district_id"=>$data->district_id,"village_id"=>$data->village_id,"app_type"=>"general"))',
        'visible'=>Yii::app()->controller->action->id!="view",
    )
);
?>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'general-site-grid',
    'type' => 'striped bordered condensed',
    'template'=>'{items}',
    'dataProvider' => $general->getSiteProvider(),
    'columns' => $columns,
));
?>