<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'attach-file-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'), // ADD THIS
)); ?>

	<p class="help-block"><?php echo Yii::t('app','Fields with')?> <span class="required">*</span> <?php echo Yii::t('app','are required')?>.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->hiddenField($model,'document_id',array('value'=>(int)$_GET['docid'],'class'=>'span5')); ?>	
	<?php echo $form->textFieldRow(Document::model()->findByPK((int)$_GET['docid']),'document_title',array('class'=>'span5','readonly'=>'readonly')); ?>	
	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5')); ?>
	<?php echo $form->fileFieldRow($model,'file_name',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
