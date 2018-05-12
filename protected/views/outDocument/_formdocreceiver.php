<h4><?php echo Yii::t('app','Add a receiver')?></h4>
<?php 
echo $form->dropDownListRow($receiver,'to_organization_id',
CHtml::listData(Organization::getlistfromtoreciever(), 'id', 'organization_name'),
array(
    'options'=>array($receiver->to_organization_id=>array('selected'=>'selected')),
    'empty'=>Yii::t('app','--Please select--'),
	'class'=>'span5',
)); ?>

<?php //echo $form->textFieldRow($receiver,'document_status_id',array('class'=>'span5')); ?>
<?php echo $form->dropDownListRow($receiver,'document_status_id',
    CHtml::listData(DocumentStatus::model()->findAll('status_type="OUT"'), 
    'id', 'status_description'),
    array(
        'options'=>array($receiver->document_status_id=>array('selected'=>'selected')),
        'empty'=>Yii::t('app','--Please select--'),
    	'class'=>'span5',
    )); ?>
<?php // echo $form->textFieldRow($receiver,'status_date',array('class'=>'span5')); ?>
<?php echo $form->textFieldRow($receiver,'receiver_name',array('class'=>'span5','maxlength'=>255)); ?>
<?php echo CHtml::ajaxButton(
				Yii::t('app','Add'),
				Yii::app()->controller->createURL('AddReceiver'),
				array(
					'type'=>'POST',
					'update'=>"#receivers",
					//'update'=>"#receiverslist-grid"
				),array('name'=>'add'.uniqID())
			)?>
