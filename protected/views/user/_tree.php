<?php $this->widget('CTreeView',array(
    'id'=>'org-treeview',
    'data'=>(Yii::app()->session->get('org-treeview') != NULL) ? Yii::app()->session->get('org-treeview') : Organization::model()->treeData(),
    'animated'=>'fast',
    'collapsed'=>true,
    'htmlOptions'=>array(
        'class'=>'treeview-red'
    )
)); ?>
