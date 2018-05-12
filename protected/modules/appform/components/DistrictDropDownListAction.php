<?php
class DistrictDropDownListAction extends CAction
{
    public $modelClass;
    
    public function run()
    {
        $controller = $this->getController();
        if (isset($_POST[$this->modelClass]['province_id'])) {
            $province_id='';
            if (!is_array($_POST[$this->modelClass]['province_id'])) {
                $province_id = (int)$_POST[$this->modelClass]['province_id'];
            } else {
                $province_id = (int)$_POST[$this->modelClass]['province_id'][0];
            }
            $data = District::model()->findAll(
                'province_id=:pid',
                array(
                    ':pid'=>$province_id,
            ));
            $data=CHtml::listData($data, 'id', District::representingColumn());
            echo CHtml::tag('option',array('value'=>''),CHtml::encode(
                Yii::t('app', 'Please select District')),true);
            foreach ($data as $value=>$name) {
                echo CHtml::tag('option',array('value'=>$value),
                    CHtml::encode($name),true);
            }
        } else {
            //return one option in the list
            echo CHtml::tag('option',array('value'=>''),CHtml::encode(
                Yii::t('app', 'Please select District')),true);
        }
    }
}