
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<div class="row-fluid">
	<div class="span4">
	<?php echo $form->dropDownListRow($model,'document_type_id',
	           CHtml::listData(DocumentType::model()->findAll(), 'id', 'description'),
	       		 array('prompt' => '--- Select document type ---','labelOptions'=>array('label'=>Yii::t('app','Document type')),'class'=>'span12'));?>
	</div>
	<div class="span2">
	<?php echo $form->textFieldRow($model,'office_no',array('class'=>'span12','maxlength'=>255)); ?>
	</div>
	<div class="span2">
	<?php echo $form->datepickerRow($model, 'created',array('labelOptions'=>array('label'=>Yii::t('app','Date create')),'options'=>array('format' => 'yyyy-mm-dd'),'class'=>'span12'));?>
	</div>
	<?php //echo $form->textFieldRow($model,'sender_ref',array('class'=>'span5','maxlength'=>60)); ?>
	<?php //echo $form->textFieldRow($model,'office_no',array('class'=>'span5','maxlength'=>255)); ?>

	<?php //echo $form->textFieldRow($model,'document_status_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'status_date',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'from_organization_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'to_organization_id',array('class'=>'span5')); ?>
	<div  class="span2"><br/>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>Yii::t('app','Search'),
		)); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
