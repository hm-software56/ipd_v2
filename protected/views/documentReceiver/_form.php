<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'document-receiver-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'out_document_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'to_organization_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'document_status_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'status_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'receiver_name',array('class'=>'span5','maxlength'=>255)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
