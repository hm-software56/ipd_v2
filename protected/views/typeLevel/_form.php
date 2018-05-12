<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'type-level-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block"><?php echo Yii::t('app','Fields with')?> <span class="required">*</span> <?php echo Yii::t('app','are required')?>.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'parent_id',array('value'=>!empty($_GET['parent'])? $_GET['parent']: $model->parent_id , 'readonly'=>true)); ?>
	<?php 
	if($model->parent_id!=NULL)
	{
		echo $form->labelEx($model,'parent_id');
		echo CHtml::textField('Parent',TypeLevel::model()->findByPK($model->parent_id)->description,array('readonly'=>true)); 
	}
	elseif(isset($_GET['parent']))
	{
		echo $form->labelEx($model,'parent_id');
		echo CHtml::textField('Parent',TypeLevel::model()->findByPK((int)$_GET['parent'])->description,array('readonly'=>true)); 
	}
	?>
	<?php echo $form->textFieldRow($model,'description',array('maxlength'=>255)); ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
