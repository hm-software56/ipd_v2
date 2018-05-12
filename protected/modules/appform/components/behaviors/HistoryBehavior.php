<?php

class HistoryBehavior extends CActiveRecordBehavior
{
    private $_oldAttributes = array();
    
    /**
     * (non-PHPdoc)
     * @see CActiveRecordBehavior::afterSave()
     */
    public function afterSave($event)
    {
        $modelClass = get_class($this->owner);
        $historyClass = $modelClass.'History';
        
        $newattributes = $this->owner->getAttributes();
        $oldattributes = $this->getOldAttributes();
        
        $updateable = FALSE;

        $model = new $historyClass;
        foreach ($newattributes as $name=>$value) {
            $model->$name=$value;
            $old = '';
            if (!empty($oldattributes[$name])) {
                $old = $oldattributes[$name];
            }
            if ($value != $old) {
                $updateable = TRUE;
            }
        }
        $userid = (Yii::app()->user->id != '') ? Yii::app()->user->id : 0;
        $model->user_action_id = $userid;
        $model->action_time = new CDbExpression('NOW()');
        
        if ($this->owner->isNewRecord || $updateable == TRUE) {
            $model->save();
        }
    }
        
    /**
     * (non-PHPdoc)
     * @see CActiveRecordBehavior::afterFind()
     */
    public function afterFind($event)
    {
        $this->setOldAttributes($this->owner->getAttributes());
    }
    
    /**
     * Get Old Attributes
     */
    public function getOldAttributes()
    {
        return $this->_oldAttributes;
    }
    
    /**
     * Set Old Attributes
     * @param array $value
     */
    public function setOldAttributes($value)
    {
        $this->_oldAttributes = $value;
    }
}