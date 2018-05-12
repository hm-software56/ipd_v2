<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'fee-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'fee_description',array('class'=>'span5','maxlength'=>45)); ?>
	
	<?php echo $form->dropDownListRow($model,'fee_type',Utils::enumItem($model, 'fee_type'),array('prompt' => '--Please Select --','class'=>'span5')); ?>
	
	<?php echo $form->textFieldRow($model,'amount_to_budget',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'amount_to_department',array('class'=>'span5')); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
