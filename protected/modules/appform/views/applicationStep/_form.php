<div class="form">


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'application-step-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->textFieldRow($model,'step_description');?>
		<?php echo $form->dropDownListRow($model,'email_notify',array(
		    '0'=>'Not Notify','1'=>'Notify',
		));?>
		<?php echo $form->ckEditorRow($model,'email_content',array(
		    'options'=>array(
		        'fullpage'=>'js:true', 
		        'width'=>'640', 
		        'resize_maxWidth'=>'640',
		        'resize_minWidth'=>'320'
		    )
		));?>
<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->