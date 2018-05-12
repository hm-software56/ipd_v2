<?php Yii::app()->bootstrap->registerCoreCss(); ?>
<?php Yii::app()->bootstrap->registerCoreScripts(); ?>
<?php Yii::app()->bootstrap->registerYiiCss(); ?>

<?php

$this->breadcrumbs = array(
	ApplicationStep::label(2),
	Yii::t('app', 'Index'),
);

?>

<fieldset>
	<legend><?php echo GxHtml::encode(ApplicationStep::label(2)); ?></legend>
	
    <?php $this->widget('bootstrap.widgets.TbGridView',array(
        'id'=>'application-step-grid',
        'dataProvider'=>$model->search(),
        'summaryText' => Yii::t('appform', 'Displaying {start}-{end} of {count} result(s).'),
        'emptyText' => Yii::t('appform', 'No results found.'),
        'columns'=>array(
            array(
                'class'=>'bootstrap.widgets.TbEditableColumn',
                'name'=>'step_description',
                'editable'=>array(
                    'type'=>'text',
                    'url'=>Yii::app()->controller->createUrl('editableSaver'),
                    'placement'=>'right',
                ),
            ),
            array(
                'class'=>'bootstrap.widgets.TbEditableColumn',
                'name'=>'email_notify',
                'editable'=>array(
                    'type'=>'select',
                    'url'=>Yii::app()->controller->createUrl('editableSaver'),
                    'source'=>array('0'=>'Not Notify', '1'=>'Notify'),
                ),
            ),
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )); ?>
</fieldset>
