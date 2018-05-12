<?php

class ReportController extends GxController {

    public $pagSize = 20;

    /**
     * to report all existing product in 
     * product table
     */
    public function actionReportAllProduct() {

        $criteria = new CDbCriteria;
        $criteria->with = array(
            'productType',
        );
        $criteria->addInCondition('productType.product_type', array('Part', 'Lubricant'));
        $models = Product::model()->findAll($criteria);

        $dataProvider = new CArrayDataProvider($models, array(
            'sort' => array(
                'defaultOrder' => 'product_description ASC',
                'attributes' => array(
                    'id' => array(
                        'asc' => 'id',
                        'desc' => 'id DESC ',
                    ),
                    'product_code' => array(
                        'asc' => 'product_code',
                        'desc' => 'product_code DESC',
                    ),
                    'product_description' => array(
                        'asc' => 'product_description',
                        'desc' => 'product_description DESC',
                    ),
                    'quantity_on_hand' => array(
                        'asc' => 'quantity_on_hand',
                        'desc' => 'quantity_on_hand DESC',
                    ),
                    'quantity_on_order' => array(
                        'asc' => 'quantity_on_order',
                        'desc' => 'quantity_on_order DESC',
                    ),
                    'list_price' => array(
                        'asc' => 'list_price',
                        'desc' => 'list_price DESC',
                    ),
                    '*',
                )
            ),
            'pagination' => array(
                'pageSize' => $this->pagSize,
            )
        ));

        $this->render('_reportAllProduct', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPrintPDFAllProduct() {

        $criteria = new CDbCriteria;
        $criteria->with = array(
            'productType',
        );
        $criteria->addInCondition('productType.product_type', array('Part', 'Lubricant'));
        $models = Product::model()->findAll($criteria);
        $this->renderPartial('_printPDFAllProduct', array(
            'models' => $models)
        );
    }

    public function actionReportOnOrderProduct() {

        $criteria = new CDbCriteria;
        $criteria->with = array(
            'productType',
        );

        $criteria->condition = 'quantity_on_order>:quantity_on_order';
        $criteria->params = array(
            'quantity_on_order' => 0
        );

        $models = Product::model()->findAll($criteria);

        $dataProvider = new CArrayDataProvider($models, array(
            'sort' => array(
                'defaultOrder' => 'product_description ASC',
                'attributes' => array(
                    'id' => array(
                        'asc' => 'id',
                        'desc' => 'id DESC ',
                    ),
                    'product_code' => array(
                        'asc' => 'product_code',
                        'desc' => 'product_code DESC',
                    ),
                    'product_description' => array(
                        'asc' => 'product_description',
                        'desc' => 'product_description DESC',
                    ),
                    'quantity_on_hand' => array(
                        'asc' => 'quantity_on_hand',
                        'desc' => 'quantity_on_hand DESC',
                    ),
                    'quantity_on_order' => array(
                        'asc' => 'quantity_on_order',
                        'desc' => 'quantity_on_order DESC',
                    ),
                    'list_price' => array(
                        'asc' => 'list_price',
                        'desc' => 'list_price DESC',
                    ),
                    '*',
                )
            ),
            'pagination' => array(
                'pageSize' => $this->pagSize,
            )
        ));

        $this->render('_reportOnOrderProduct', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPrintOnOrderProduct() {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'productType',
        );

        $criteria->condition = 'quantity_on_order>:quantity_on_order';
        $criteria->params = array(
            'quantity_on_order' => 0
        );
        $models = Product::model()->findAll($criteria);
        $this->renderPartial('_printPDFOnOrderProduct', array(
            'models' => $models)
        );
    }

    public function actionReportProductRequisition() {
        $model = new ProductRequisitionDetail;
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'productRequisition',
        );

        $fromDate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $toDate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $model->productRequisition->fromDate = date("d/m/Y", $fromDate);
        $model->productRequisition->toDate = date("d/m/Y", $toDate);
        if (isset($_POST['ProductRequisition'])) {
            $model->productRequisition->setAttributes($_POST['ProductRequisition']);
            $model->productRequisition->fromDate = $_POST['ProductRequisition']['fromDate'];
            $model->productRequisition->toDate = $_POST['ProductRequisition']['toDate'];
            $fromDate = DateTime::createFromFormat('d/m/Y', $model->productRequisition->fromDate);
            $toDate = DateTime::createFromFormat('d/m/Y', $model->productRequisition->toDate);

            $criteria->addBetweenCondition('productRequisition.date', $fromDate->format('Y-m-d'), $toDate->format('Y-m-d'));
        } else {
            $criteria->addBetweenCondition('productRequisition.date', date("Y-m-d", $fromDate), date("Y-m-d", $toDate));
        }

        $criteria->order = 'productRequisition.date DESC';
        $criteria->compare('productRequisition.id', $model->product_requisition_id);
        $models = $model->findAll($criteria);
        $dataProvider = new CArrayDataProvider($models);
        if (isset($_POST['Print'])) {
            $this->renderPartial('_printPDFProductRequisition', array(
                'models' => $models,
                'model' => $model,
                    )
            );
        }
        $grid_id = 'product-requistion-grid';

        // Check is for AJAX request by `subscriber_grid`
        // ajax response only grid content instead entire web page
        //if(Yii::app()->request->isAjaxRequest && isset($_GET['ajax']) && $_GET['ajax'] === $grid_id)) {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_reportProductRequisition', array(
                'dataProvider' => $dataProvider,
                'grid_id' => $grid_id,
            ));
            Yii::app()->end();
        }

        $this->render('_productRequisitionForm', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'grid_id' => $grid_id,
                )
        );
    }

}

?>
