<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary(array($model,$model->userProfile)); ?>

		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model,'username'); ?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'username', array('maxlength' => 45)); ?>
			</div>
			<div class="span2">
				<?php echo $form->error($model,'username'); ?>
			</div>
		</div><!-- row -->
		
		<?php if ($model->isNewRecord):?>
		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model,'password'); ?>
			</div>
			<div class="span3">
				<?php echo $form->passwordField($model, 'password', array('maxlength' => 60)); ?>
			</div>
			<div class="span2">
				<?php echo $form->error($model,'password'); ?>
			</div>
		</div><!-- row -->
		<?php endif;?>
		
		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model,'status'); ?>
			</div>
			<div class="span4">
				<?php echo CHtml::activeDropDownList($model, 'status', Utils::enumItem($model, 'status')); ?>
			</div>
			<div class="span2">
				<?php echo $form->error($model,'status'); ?>
			</div>
		</div><!-- row -->
		
		<div class="row">
			<div class="span2">
				<?php $org=$model->userProfile->organization;?>
				<?php echo $form->labelEx($org,'region_id'); ?>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($org,'region_id',
				    CHtml::listData(Region::model()->findAll(), 'id', 'region_name'),
				    array(
				        'ajax'=>array(
				            'type'=>'POST',
				            'url'=>CController::createUrl('loadTree'),
				            'update'=>'#UserProfile_organization_id',
				        ),
				        'empty'=>Yii::t('app','--Please select--'),
				        'options'=>array($org->region_id=>array('selected'=>'selected'))
				    )
				);?>
			</div>
			<div class="span2">
				<?php echo $form->error($org,'region_id'); ?>
			</div>
		</div><!-- row -->
		
		<div class="row">
			<div class="span2">
				<?php $condition=($org->id != '') ? 'id='.$org->id: '0=1';?>
				<?php echo $form->labelEx($model->userProfile,'organization_id');?>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model->userProfile, 'organization_id',
				    CHtml::listData(Organization::model()->findAll($condition),
						'id',
						'organization_name'
				    ),
				    array(
				        'empty'=>CHtml::encode(Yii::t('app','Please select')),
				        'options'=>array($org->id=>array('selected'=>'selected'))
				    )
				);?>
			</div>
			<div class="span2">
				<?php echo $form->error($model->userProfile,'organization_id'); ?>
			</div>
		</div>
		
		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model->userProfile,'title');?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model->userProfile,'title');?>
			</div>
			<div class="span2">
				<?php echo $form->error($model->userProfile,'title');?>
			</div>
		</div>
		
		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model->userProfile,'first_name');?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model->userProfile,'first_name');?>
			</div>
			<div class="span2">
				<?php echo $form->error($model->userProfile,'first_name');?>
			</div>
		</div>
		
		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model->userProfile,'last_name');?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model->userProfile,'last_name');?>
			</div>
			<div class="span2">
				<?php echo $form->error($model->userProfile,'last_name');?>
			</div>
		</div>
		
		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model->userProfile,'birth_date');?>
			</div>
			<div class="span3">
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
			</div>
			<div class="span2">
				<?php echo $form->error($model->userProfile,'birth_date');?>
			</div>
		</div>
		
		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model->userProfile,'designation');?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model->userProfile,'designation');?>
			</div>
			<div class="span2">
				<?php echo $form->error($model->userProfile,'designation');?>
			</div>
		</div>
		
		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model->userProfile,'telephone_number');?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model->userProfile,'telephone_number');?>
			</div>
			<div class="span2">
				<?php echo $form->error($model->userProfile,'telephone_number');?>
			</div>
		</div>
		
		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model->userProfile,'mobile_number');?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model->userProfile,'mobile_number');?>
			</div>
			<div class="span2">
				<?php echo $form->error($model->userProfile,'mobile_number');?>
			</div>
		</div>
		
		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model->userProfile,'email_address');?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model->userProfile,'email_address');?>
			</div>
			<div class="span2">
				<?php echo $form->error($model->userProfile,'email_address');?>
			</div>
		</div>
		<div class="row">
		<div class="span2"><?php echo Yii::t('app','Role') ?></div>
		<div class="span2">
		<?php 
			$array = array('SingleWindow' => 'SingleWindow', 'Accounting' => 'Accounting','DG'=>'DG','Staff'=>'Staff');
			echo $form->dropDownList($assignment,'itemname',$array);
		?>
		</div>
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
