<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->document_id),array('view','id'=>$data->document_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inc_document_no')); ?>:</b>
	<?php echo CHtml::encode($data->inc_document_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_application')); ?>:</b>
	<?php echo CHtml::encode($data->is_application); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sender')); ?>:</b>
	<?php echo CHtml::encode($data->sender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sender_ref')); ?>:</b>
	<?php echo CHtml::encode($data->sender_ref); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_status_id')); ?>:</b>
	<?php echo CHtml::encode($data->document_status_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_date')); ?>:</b>
	<?php echo CHtml::encode($data->status_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('from_organization_id')); ?>:</b>
	<?php echo CHtml::encode($data->from_organization_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('to_organization_id')); ?>:</b>
	<?php echo CHtml::encode($data->to_organization_id); ?>
	<br />

	*/ ?>

</div>