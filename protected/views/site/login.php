<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'horizontalForm',
		'type'=>'horizontal',
		'htmlOptions'=>array('class'=>'well'),
		'enableClientValidation'=>true,
		'clientOptions'=>array('validateOnSubmit'=>true,),
	)); 

?>
<div id="textlogincolor" align="center">ລະບົບຕິດຕາມເອກະສານ ( Information Tracking System)</div><br/>
<div align="center">ກະລູນາປ້ອນ ຊື່ຜູ້ໃຊ້(Username) ແລະ ລະຫັດຜ່ານ(Password) ເພື່ອເຂົ້າໃຊ້ລະບົບ</div><br/>
<?php echo $form->textFieldRow($model,'username', array('class'=>'span3')); ?>
<?php echo $form->passwordFieldRow($model,'password', array('class'=>'span3')); ?>
<?php echo $form->checkboxRow($model,'rememberMe'); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'ເຂົ້າລະບົບ')); ?>

<?php $this->endWidget(); ?>
