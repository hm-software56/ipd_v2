<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'caisse-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'inc_document_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'amount_to_budget',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'amount_to_department',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'payment_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'payment_status',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5')); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
