<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('step_description')); ?>:
	<?php echo GxHtml::encode($data->step_description); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('email_notify')); ?>:
	<?php echo GxHtml::encode($data->email_notify); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('email_content')); ?>:
	<?php echo GxHtml::encode($data->email_content); ?>
	<br />

</div>