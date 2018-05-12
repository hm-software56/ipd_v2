<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inc_document_id')); ?>:</b>
	<?php echo CHtml::encode($data->inc_document_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_to_budget')); ?>:</b>
	<?php echo CHtml::encode($data->amount_to_budget); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_to_department')); ?>:</b>
	<?php echo CHtml::encode($data->amount_to_department); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_date')); ?>:</b>
	<?php echo CHtml::encode($data->payment_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_status')); ?>:</b>
	<?php echo CHtml::encode($data->payment_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />


</div>