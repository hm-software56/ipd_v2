<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_document_id')); ?>:</b>
	<?php echo CHtml::encode($data->out_document_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('to_organization_id')); ?>:</b>
	<?php echo CHtml::encode($data->to_organization_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_status_id')); ?>:</b>
	<?php echo CHtml::encode($data->document_status_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_date')); ?>:</b>
	<?php echo CHtml::encode($data->status_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receiver_name')); ?>:</b>
	<?php echo CHtml::encode($data->receiver_name); ?>
	<br />


</div>