<?php
$this->layout='column1';
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List User','url'=>array('index')),
	array('label'=>'Create User','url'=>array('create')),
	array('label'=>'Update User','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User','url'=>array('admin')),
);
?>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'userProfile.first_name',
			'value'=>$model->userProfile->first_name
		),
		array(
			'name'=>'userProfile.last_name',
			'value'=>$model->userProfile->last_name
		),
		array(
			'name'=>'userProfile.birth_date',
			'value'=>$model->userProfile->birth_date
		),
		array(
			'name'=>'userProfile.organization_id',
			'value'=>$model->userProfile->organization->organization_name
		),
		array(
			'name'=>'userProfile.designation',
			'value'=>$model->userProfile->designation
		),
		array(
			'name'=>'userProfile.telephone_number',
			'value'=>$model->userProfile->telephone_number
		),
		array(
			'name'=>'userProfile.mobile_number',
			'value'=>$model->userProfile->mobile_number
		),
		array(
			'name'=>'userProfile.email_address',
			'value'=>$model->userProfile->email_address
		),
		'username',
		'status',
	),
)); ?>
