<div id="login_l">
<div class="span5 span_tb">
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
<?php echo $form->textFieldRow($model,'username', array('class'=> 'span2 span_tb')); ?>
<?php echo $form->passwordFieldRow($model,'password', array('class'=> 'span2 span_tb')); ?>
<?php echo $form->checkboxRow($model,'rememberMe'); ?>

<div  align="right">
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'ເຂົ້າລະບົບ')); ?>
</div>

<?php $this->endWidget(); ?>
<div align="center">
	<a href="#myModal" role="button" class="btn btn-link" data-toggle="modal">ຄົ້ນ​ຫາ​ເອ​ກະ​ສານສະ​ເພາະ​ຜູ້​ລົງ​ທຶນ >></a>
	
	<!-- Modal -->
	<form action="<?=Yii::app()->BaseUrl."/index.php/site/searchpublic"?>" method="post"/>
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">ສຳ​ລັບ​ນັກ​ລົງ​ທືນ​ທີ​ຕ້ອງ​ການ​ເບີງ​ເອ​ກະ​ສານ​ຕົນ​ເອງ</h3>
		</div>
		<div class="modal-body">
			<input type="text" required name="code"  placeholder="ປ້ອນ​ລະ​ຫັດ​ເອ​ກະ​ສານ" class="span4"/>
		<?php if (Yii::app()->session['error']) : ?>
			<div style="color:red;">
				<?php echo Yii::app()->session['error']; ?>
			</div>
		<?php endif; ?>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary">ຄົ້ນ​ຫາ</button>
		</div>
	</div>
	</form>
</div>
</div>
</div>
<?php
if (Yii::app()->session['error'])
{
	unset(Yii::app()->session['error']);
?>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
<?php
}
?>