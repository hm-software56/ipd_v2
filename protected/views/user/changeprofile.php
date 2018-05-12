
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>
		
		<div class="row,span5">
		<?php echo $form->labelEx($model->userProfile,'title');?>
		<?php echo $form->textField($model->userProfile,'title');?>
		<?php echo $form->error($model->userProfile,'title');?>
		</div>
		
		<div class="row,span5">
		<?php echo $form->labelEx($model->userProfile,'first_name');?>
		<?php echo $form->textField($model->userProfile,'first_name');?>
		<?php echo $form->error($model->userProfile,'first_name');?>
		</div>
		
		<div class="row,span5">
		<?php echo $form->labelEx($model->userProfile,'last_name');?>
		<?php echo $form->textField($model->userProfile,'last_name');?>
		<?php echo $form->error($model->userProfile,'last_name');?>
		</div>
		
		<div class="row,span5">
		<?php echo $form->labelEx($model->userProfile,'birth_date');?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'id'=>'birth_date',
			'model'=>$model->userProfile,
			'attribute'=>'birth_date',
			'value'=>$model->userProfile->birth_date,
		    'language' => 'en-GB',
		    //additional javascript options for the date picker plugin
		    'options'=>array(
        			'showAnim'=>'fold',
					'dateFormat'=>'dd-M-yy',
					'showAnim'=>'slide', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
					'showOn'=>'button', // 'focus', 'button', 'both'
					'buttonText'=>'Select from calendar',
					// Image Url located in /images/calendar.jpeg  
					'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.jpeg', 
					'buttonImageOnly'=>true,
					// user will be able to change month and year
					'changeMonth' => 'true',
		            'changeYear' => 'true',
					//shows the button panel under the calendar (buttons like "today" and "done")
		            'showButtonPanel' => 'true',
		            'yearRange'=>'-60:-16',
		            'defaultDate'=>'-40y',
    		        ),		    			    		
		));
		?>
		<?php echo $form->error($model->userProfile,'birth_date');?>
		</div>
		
		<div class="row,span5">
		<?php echo $form->labelEx($model->userProfile,'designation');?>
		<?php echo $form->textField($model->userProfile,'designation');?>
		<?php echo $form->error($model->userProfile,'designation');?>
		</div>
		
		<div class="row,span5">
		<?php echo $form->labelEx($model->userProfile,'telephone_number');?>
		<?php echo $form->textField($model->userProfile,'telephone_number');?>
		<?php echo $form->error($model->userProfile,'telephone_number');?>
		</div>
		
		<div class="row,span5">
		<?php echo $form->labelEx($model->userProfile,'mobile_number');?>
		<?php echo $form->textField($model->userProfile,'mobile_number');?>
		<?php echo $form->error($model->userProfile,'mobile_number');?>
		</div>
		
		<div class="row,span5">
		<?php echo $form->labelEx($model->userProfile,'email_address');?>
		<?php echo $form->textField($model->userProfile,'email_address');?>
		<?php echo $form->error($model->userProfile,'email_address');?>
		</div>
	<div class="span8">
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
	</div>
<?php $this->endWidget(); ?>
