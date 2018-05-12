<?php
class VillageDropDownListAction extends CAction
{
    public $modelClass;
    
    public function run()
    {
        $controller = $this->getController();
        if (isset($_POST[$this->modelClass]['district_id'])) {
            $district_id='';
            if (!is_array($_POST[$this->modelClass]['district_id'])) {
                $district_id = (int)$_POST[$this->modelClass]['district_id'];
            } else {
                $district_id = (int)$_POST[$this->modelClass]['district_id'][0];
            }
            $data = Village::model()->findAll(
                'district_id=:did',
                array(
                    ':did'=>$district_id,
            ));
            $data=CHtml::listData($data, 'id', Village::representingColumn());
            echo CHtml::tag('option',array('value'=>''),CHtml::encode(
                Yii::t('app', 'Please select Village')),true);
            foreach ($data as $value=>$name) {
                echo CHtml::tag('option',array('value'=>$value),
                    CHtml::encode($name),true);
            }
        } else {
            //return one option in the list
            echo CHtml::tag('option',array('value'=>''),CHtml::encode(
                Yii::t('app', 'Please select Village')),true);
        }
    }
}