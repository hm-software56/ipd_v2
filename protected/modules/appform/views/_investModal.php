<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'myModal')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><?php echo Yii::t('appform', 'Invest Company'); ?> </h4>
</div>

<div class="modal-body">
<?php echo $form->textFieldRow($investCompany,'company_name');?>
<?php echo $form->textFieldRow($investCompany,'register_place');?>
<?php /* echo $form->datePickerRow($investCompany,'register_date',array(
    'options'=>array('format'=>'dd-mm-yyyy'),
));*/?>
<div class="row">
<?php echo $form->labelEx($investCompany,'register_date'); ?>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'model' => $investCompany,
    'attribute' => 'register_date',
	'options' => array(
        'dateFormat' => 'dd-mm-yy',     // format of "2012-12-25"
    ),
    'htmlOptions' => array(
        'size' => '10',         // textField size
        'maxlength' => '10',    // textField maxlength
    ),
));
?>
<?php echo $form->error($investCompany,'register_date'); ?>
</div>

<?php echo $form->textFieldRow($investCompany,'total_capital');?>
<?php echo $form->textFieldRow($investCompany,'capital');?>
<?php echo $form->textFieldRow($investCompany,'president_first_name');?>
<?php echo $form->textFieldRow($investCompany,'president_last_name');?>
<?php echo $form->textFieldRow($investCompany,'president_nationality');?>
<?php echo $form->textFieldRow($investCompany,'president_position');?>
<?php echo $form->textFieldRow($investCompany,'headquarter_address');?>
<?php echo $form->dropDownListRow($investCompany,'business_sector_id',
    CHtml::listData(BusinessSector::model()->findAll(), 'id', BusinessSector::representingColumn())
);?>
</div>

<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'ajaxButton',
        'type' => 'primary',
        'label' => Yii::t('appform', 'Add'),
        'url' => $this->createUrl('applicationForm/addInvest'),
	    'ajaxOptions'=>array(
	        'type'=>'POST',
	        'url'=>$this->createUrl('applicationForm/addInvest'),
	        'success'=>'js:function(data){
				$.fn.yiiGridView.update("invest-grid");
				if(data!="") {
					alert(data);
				}
	        }',
	    ),
        'htmlOptions' => array('data-dismiss' => 'modal'),
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
