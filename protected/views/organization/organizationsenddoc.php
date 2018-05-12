<?php
$this->layout="Null";
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'organization-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'from_organization_id',array('value'=>$id)); ?>
	<?php echo CHtml::checkBoxList("to_organization_id", $select, $organization, array('labelOptions'=>array('style'=>'display:inline;font-weight:normal'))); ?> 
	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
