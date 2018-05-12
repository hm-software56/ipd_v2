<?php
$this->layout="null";
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'caisse-form',
	'enableAjaxValidation'=>false,
	'action' => Yii::app()->createUrl('caisse/payment'), 
)); ?>
<div class="row">
	<div class="span7">ກະຊວງ ແຜນການ ແລະ ການລົງທືນ</div>
</div>
<div class="row">
	<div class="span3">ກົມສົ່ງເສີມການລົງທືນ</div>
	<div class="span4" align="right">ເລກທີ່:<?php echo $model->id?></div>
</div>
<hr/>
<div class="row">
	<div class="span7">ອົງກອນ/ບໍລິສັດ: <?php echo $model->incDocument->sender?></div>
</div>
<div class="row">
	<div class="span7">ເລື່ອງ: <?php echo $model->incDocument->fee->fee_description?></div>
</div>
<div class="row">
<div class="span5">ອີງຕາມເອກະສານສະບັບເລກທີ່: <?php echo $model->incDocument->inc_document_no?></div>
	<div class="span2">ລົງວັນທີ່: <?php echo date('d/m/Y',strtotime($model->incDocument->document->created))?></div>
</div>
<div class="row">
	<div class="span7">ລວມເປັນຈໍານວນເງີນທັງໝົດ:<?php echo number_format($model->amount_to_budget+$model->amount_to_department)?></div>
</div>
<?php 
	echo CHtml::hiddenField('id',$model->id, array('class'=>'span1'));
	echo CHtml::hiddenField('status','1', array('class'=>'span1'));
?>
 <div class="modal-footer">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Comfirm payment',
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'label' => 'Cancle',
			'url'=>'#',
			'htmlOptions' => array('data-dismiss' => 'modal'),
		)); ?>
    </div>
<?php $this->endWidget(); ?>
