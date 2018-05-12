<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'changeStatus_form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($receiver); ?>
	
	
	<?php echo $form->dropDownListRow($receiver,'document_status_id',
    CHtml::listData(DocumentStatus::model()->findAll('status_type="OUT"'), 
    'id', 'status_description'),
    array(
        'options'=>array($receiver->document_status_id=>array('selected'=>'selected')),
        'empty'=>Yii::t('app','--Please select--'),
    )); ?>
    <?php echo $form->hiddenField($receiver,'id')?>

<?php $this->endWidget(); ?>