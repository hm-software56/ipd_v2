<?php
/**
 * @model caisse
 */
if($model)
{
?>
<fieldset>
<div class="container-fluid">
	<div class="span3">
		ກະຊວງ ແຜນການ ແລະ ການລົງທຶນ
	</div>
	<div>
		<div class="span3">
			ກົມສົ່ງເສີມການລົງທຶນ
		</div>
		<div class="span3 offset4">
			ເລກທີ <?php echo $model->inDocument->in_document_no?>
		</div>
	</div>
	<div>
		<div class="span4 offset4">(ໃບບິນຈ່າຍເງິນ)</div>
	</div>
	<div>
		<div class="span5">ຊີ່ບໍລິສັດ</div>
	</div>
	<div>
		<div class="span5">ເລື່ອງ :</div>
	</div>
	<div>
		<div class="span5">ອີງຕາມເອກກະສານສະບັບເລກທີ : <?php echo $model->inDocument->inc_document_no?> <?php echo $model->inDocument->document->created?></div>
	</div>
	<div>
		<div>
			<div class="span5">ພະແນກແຜນການສັງລວມ ແລະ ບໍລິການ (ໜ່ວຍງານປະຕູດຽວ)</div>
		</div>
		<div class="span4 offset4">ວັນທີ: <?php echo date("d-m-Y H:i:s")?></div>
	</div>
	<div>
		<div>
			ຊີ່ ແລະ ເບີໂທລະສັບຜູ້ມາພົວພັນເອກກະສານ
		</div>
		<div>
			ທ້າວຫຼື ນາງ
		</div>
		<div>
			<div class="span3">ລາຍເຊັນຜູ້ມາພົວພັນ</div>
			<div class="span3 offset5"><?php echo $model->amount_to_budget + $model->amount_to_department;?></div>
		</div>
		<div>
			ເບີໂທລະສັບ
		</div>
	</div>
</div>
</fieldset>
<?php 
}