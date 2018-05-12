<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fee_description')); ?>:</b>
	<?php echo CHtml::encode($data->fee_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_to_budget')); ?>:</b>
	<?php echo CHtml::encode($data->amount_to_budget); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_to_department')); ?>:</b>
	<?php echo CHtml::encode($data->amount_to_department); ?>
	<br />


</div>