<?php

class ApplicationFormController extends GxController {

    public $layout = '//layouts/column1';
    public $inc_document_id;
    
    private function sendMail($model)
    {
    	
        $step = ApplicationStep::model()->findByPk($model->application_step_id);
        
        if ($step->email_notify == 1 && $step->email_content != '') {
      
            $Indoc=IncDocument::model()->findByAttributes(array('document_id'=>$this->inc_document_id));
            $emailCheck = ApplicationEmail::model()->findByAttributes(array(
                'application_form_id'=>$model->id,
                'application_step_id'=>$model->application_step_id
            ));
            
            if ($emailCheck != NULL) {    //Already sent
                return;
            }
            
            $email_content=str_replace('XXXXX', $Indoc->inc_document_no, $step->email_content);
            $email_content1=str_replace('YYYYY',Yii::app()->params->Contact_ipd, $email_content);
            $email_content2=str_replace('ZZZZZ', strlen($Indoc->inc_document_no), $email_content1);
            
            $mail=new YiiMailMessage;
            $mail->setSubject('Notification from Document Tracking System');
            //$mail->setBody($step->email_content,'text/html');
            $mail->setBody($email_content2,'text/html');
            $mail->from=array('test@dev.cyberia.la'=>'IPD');
            $mail->addTo($model->contact_email);
            Yii::app()->mail->send($mail);
            
            //save email
            $appEmail = new ApplicationEmail;
            $appEmail->application_form_id = $model->id;
            $appEmail->application_step_id = $model->application_step_id;
            $appEmail->email_date = date('Y-m-d');
            $appEmail->save();
        }
    }
    
	public function actionView($id) {
	    $model = $this->loadModel($id, 'ApplicationForm');
	    
	    if ($model === NULL) {
	        throw new CHttpException(403, 'Application not found');
	    }
	    
	    $myview = '';
	    
	    switch ($model->application_type_id) {
	        case ApplicationType::ELECTRICITY:
	            $electric = Electric::model()->findByPk($model->id);
	            $this->render('viewElectric',array(
	                'model'=>$model,
	                'electric'=>$electric,
	                'projectSite'=>new ElectricProjectSite,
	                'investCompany'=>new InvestCompany,
	            ));
	            break;
	        case ApplicationType::MINING:
	            $mining = Mining::model()->findByPk($model->id);
	            $this->render('viewMining',array(
	                'model'=>$model,
	                'mining'=>$mining,
	                'projectSite'=>new MiningProjectSite,
	                'investCompany'=>new InvestCompany,
	            ));
	            break;
	        case ApplicationType::GENERAL:
	            $general = General::model()->findByPk($model->id);
	            $this->render('viewGeneral',array(
	                'model'=>$model,
	                'general'=>$general,
	                'projectSite'=>new GeneralProjectSite,
	                'investCompany'=>new InvestCompany,
	            ));
	            break;
	        case ApplicationType::REPRESENTATIVE:
	            $repoffice = RepOffice::model()->findByAttributes(array(
	                'application_form_id'=>$model->id
	            ));
	            $this->render('viewRepOffice',array(
	                'model'=>$model,
	                'repoffice'=>$repoffice,
	            ));
	            break;
	    }
	}
	
	public function actionCreateElectric()
	{
	    $model = new ApplicationForm;
	    $electric = new Electric;
        $model->inc_document_id = $this->inc_document_id;
        $model->application_type_id = ApplicationType::ELECTRICITY;
        $projectSite = new ElectricProjectSite;
        $investCompany = new InvestCompany;
        
        //Electric Session
        if (Yii::app()->session->get('electric') != NULL) {
            $electric = Yii::app()->session->get('electric');
        } else {
            Yii::app()->session->add('electric', $electric);
        }
        
        //Application Form Session
        if (Yii::app()->session->get('eappform') != NULL) {
            $model = Yii::app()->session->get('eappform');
        } else {
            Yii::app()->session->add('eappform', $model);
        }
	    
	    if (isset($_POST['ApplicationForm']) && isset($_POST['Electric'])) {
	        $model->setAttributes($_POST['ApplicationForm']);
	        $electric->setAttributes($_POST['Electric']);
	        $model->unsetAttributes(array('id'));
	        $electric->unsetAttributes(array('application_form_id'));
            $model->inc_document_id = $this->inc_document_id;
            $model->application_type_id = ApplicationType::ELECTRICITY;
            
            $validateArray = array(
                'project_name',
                'company_name',
                'mou',
                'develop_contract',
                'concession_contract',
            );
            
            if ($electric->validate($validateArray)) {
                $connection = Yii::app()->db;
                $connection->autoCommit=FALSE;
                $transaction = $connection->beginTransaction();
                try {
                    if ($model->save()) {
                        //Set app id to electric
                        $electric->application_form_id=$model->id;
                        
                        //Save Invest company
                        if (count($model->invests) > 0) {
                            InvestCompany::model()->deleteAllByAttributes(array(
                                'application_form_id'=>$model->id
                            ));
                            foreach ($model->invests as $invest) {
                                $investCompany = new InvestCompany;
                                $investCompany->application_form_id = $model->id;
                                $investCompany->company_name = $invest->company_name;
                                $investCompany->register_place = $invest->register_place;
                                $investCompany->register_date = $invest->register_date;
                                $investCompany->total_capital = $invest->total_capital;
                                $investCompany->capital = $invest->capital;
                                $investCompany->president_first_name = $invest->president_first_name;
                                $investCompany->president_last_name = $invest->president_last_name;
                                $investCompany->president_nationality = $invest->president_nationality;
                                $investCompany->president_position = $invest->president_position;
                                $investCompany->headquarter_address = $invest->headquarter_address;
                                $investCompany->business_sector_id = $invest->business_sector_id;
                                $investCompany->save();
                            }
                        }
            
                        //$electric->save();
                        if ($electric->save()) {
                            if (count($electric->sites) > 0) {
                                ElectricProjectSite::model()->deleteAllByAttributes(array(
                                    'electric_application_form_id'=>$electric->application_form_id
                                ));
                                
                                foreach ($electric->sites as $site) {
                                    $projectSite = new ElectricProjectSite;
                                    $projectSite->electric_application_form_id = $electric->application_form_id;
                                    $projectSite->province_id = $site->province_id;
                                    $projectSite->district_id = $site->district_id;
                                    $projectSite->village_id = $site->village_id;
                                    $projectSite->save();
                                }
                            }
                        } else {
                            throw new Exception('Cannot save application1');
                        }
                    } else {
                        throw new Exception('Cannot save application2');
                    }
                    
                    $this->sendMail($model);
                    
                    $transaction->commit();
                    $connection->autoCommit=TRUE;
                    
                    Yii::app()->session->add('eappform', NULL);
                    Yii::app()->session->add('electric', NULL);
                    $this->redirect(array('view','id'=>$model->id));
                } catch (Exception $e) {
                    $transaction->rollback();
                    $connection->autoCommit=TRUE;
                    throw new CHttpException(403, $e->getMessage());
                }
            }
            
            Yii::app()->session->add('eappform', $model);
            Yii::app()->session->add('electric', $electric);
	    }
	    
	    $this->render('createElectric',array(
	        'model'=>$model,
	        'electric'=>$electric,
	        'projectSite'=>$projectSite,
	        'investCompany'=>$investCompany,
	    ));
	}
	
	public function actionUpdateElectric($id)
	{
	    $model = $this->loadModel($id, 'ApplicationForm');
	    $electric = $this->loadModel($id, 'Electric');
	    $projectSite = new ElectricProjectSite;
        $investCompany = new InvestCompany;

        //Electrict Session
        if (Yii::app()->session->get('electric') != NULL) {
            $electric = Yii::app()->session->get('electric');
        } else {
            Yii::app()->session->add('electric', $electric);
        }
        
        //Application Form Session
        if (Yii::app()->session->get('eappform') != NULL) {
            $model = Yii::app()->session->get('eappform');
        } else {
            Yii::app()->session->add('eappform', $model);
        }
        
        //Form submit
        if (isset($_POST['ApplicationForm']) && isset($_POST['Electric'])) {
            $model->setAttributes($_POST['ApplicationForm']);
	        $electric->setAttributes($_POST['Electric']);
	        
	        $validateArray = array(
                'project_name',
                'company_name',
                'mou',
                'develop_contract',
                'concession_contract',
            );
            
            //Validate Electric
            if ($electric->validate($validateArray)) {
                $connection = Yii::app()->db;
                $connection->autoCommit=FALSE;
                $transaction = $connection->beginTransaction();
                try {
                    if ($model->save()) {                        
                        //Save Invest company
                        if (count($model->invests) > 0) {
                            InvestCompany::model()->deleteAllByAttributes(array(
                                'application_form_id'=>$model->id
                            ));
                            foreach ($model->invests as $invest) {
                                $investCompany = new InvestCompany;
                                $investCompany->application_form_id = $model->id;
                                $investCompany->company_name = $invest->company_name;
                                $investCompany->register_place = $invest->register_place;
                                $investCompany->register_date = $invest->register_date;
                                $investCompany->total_capital = $invest->total_capital;
                                $investCompany->capital = $invest->capital;
                                $investCompany->president_first_name = $invest->president_first_name;
                                $investCompany->president_last_name = $invest->president_last_name;
                                $investCompany->president_nationality = $invest->president_nationality;
                                $investCompany->president_position = $invest->president_position;
                                $investCompany->headquarter_address = $invest->headquarter_address;
                                $investCompany->business_sector_id = $invest->business_sector_id;
                                $investCompany->save();
                            }
                        }

                        if ($electric->save()) {
                            if (count($electric->sites) > 0) {
                                ElectricProjectSite::model()->deleteAllByAttributes(array(
                                    'electric_application_form_id'=>$electric->application_form_id
                                ));
                                
                                foreach ($electric->sites as $site) {
                                    $projectSite = new ElectricProjectSite;
                                    $projectSite->electric_application_form_id = $electric->application_form_id;
                                    $projectSite->province_id = $site->province_id;
                                    $projectSite->district_id = $site->district_id;
                                    $projectSite->village_id = $site->village_id;
                                    $projectSite->save();
                                }
                            }
                        } else {
                            throw new Exception('Cannot save application1');
                        }
                    } else {
                        throw new Exception('Cannot save application2');
                    }
                    
                    $this->sendMail($model);
                    
                    $transaction->commit();
                    $connection->autoCommit=TRUE;
                    Yii::app()->session->add('eappform', NULL);
                    Yii::app()->session->add('electric', NULL);
                    $this->redirect(array('view','id'=>$model->id));
                } catch (Exception $e) {
                    $transaction->rollback();
                    $connection->autoCommit=TRUE;
                    throw new CHttpException(403, $e->getMessage());
                }
            }
            Yii::app()->session->add('eappform', $model);
            Yii::app()->session->add('electric', $electric);
        }
        
        $this->render('updateElectric',array(
	        'model'=>$model,
	        'electric'=>$electric,
	        'projectSite'=>$projectSite,
	        'investCompany'=>$investCompany,
	    ));
	}
	
	public function actionCreateMining()
	{
	    $model = new ApplicationForm;
	    $mining = new Mining;
        $model->inc_document_id = $this->inc_document_id;
        $model->application_type_id = ApplicationType::MINING;
        $projectSite = new MiningProjectSite;
        $investCompany = new InvestCompany;
        //Mining Session
        if (Yii::app()->session->get('mining') != NULL) {
            $mining = Yii::app()->session->get('mining');
        } else {
            Yii::app()->session->add('mining', $mining);
        }
        
        //Application Form Session
        if (Yii::app()->session->get('eappform') != NULL) {
            $model = Yii::app()->session->get('eappform');
        } else {
            Yii::app()->session->add('eappform', $model);
        }
	    
	    if (isset($_POST['ApplicationForm']) && isset($_POST['Mining'])) {
	        $model->setAttributes($_POST['ApplicationForm']);
	        $mining->setAttributes($_POST['Mining']);
	        $model->unsetAttributes(array('id'));
	        $mining->unsetAttributes(array('application_form_id'));
            $model->inc_document_id = $this->inc_document_id;
            $model->application_type_id = ApplicationType::MINING;
            
            $validateArray = array(
                'company_name',
                'objective',
                'total_capital',
                'capital',
                'fixed_asset',
                'current_asset',
            );
            
            if ($mining->validate($validateArray)) {
                $connection = Yii::app()->db;
                $connection->autoCommit=FALSE;
                $transaction = $connection->beginTransaction();
                try {
                    if ($model->save()) {
                        //Set app id to Mining
                        $mining->application_form_id=$model->id;
                        
                        //Save Invest company
                        if (count($model->invests) > 0) {
                            InvestCompany::model()->deleteAllByAttributes(array(
                                'application_form_id'=>$model->id
                            ));
                            foreach ($model->invests as $invest) {
                                $investCompany = new InvestCompany;
                                $investCompany->application_form_id = $model->id;
                                $investCompany->company_name = $invest->company_name;
                                $investCompany->register_place = $invest->register_place;
                                $investCompany->register_date = $invest->register_date;
                                $investCompany->total_capital = $invest->total_capital;
                                $investCompany->capital = $invest->capital;
                                $investCompany->president_first_name = $invest->president_first_name;
                                $investCompany->president_last_name = $invest->president_last_name;
                                $investCompany->president_nationality = $invest->president_nationality;
                                $investCompany->president_position = $invest->president_position;
                                $investCompany->headquarter_address = $invest->headquarter_address;
                                $investCompany->business_sector_id = $invest->business_sector_id;
                                $investCompany->save();
                            }
                        }
            
                        //$mining->save();
                        if ($mining->save()) {
                            if (count($mining->sites) > 0) {
                                MiningProjectSite::model()->deleteAllByAttributes(array(
                                    'mining_application_form_id'=>$mining->application_form_id
                                ));
                                
                                foreach ($mining->sites as $site) {
                                    $projectSite = new MiningProjectSite;
                                    $projectSite->mining_application_form_id = $mining->application_form_id;
                                    $projectSite->province_id = $site->province_id;
                                    $projectSite->district_id = $site->district_id;
                                    $projectSite->village_id = $site->village_id;
                                    $projectSite->save();
                                }
                            }
                        } else {
                            throw new Exception('Cannot save application1');
                        }
                    } else {
                        throw new Exception('Cannot save application2');
                    }
                    
                    $this->sendMail($model);
                    
                    $transaction->commit();
                    $connection->autoCommit=TRUE;
                    
                    Yii::app()->session->add('eappform', NULL);
                    Yii::app()->session->add('mining', NULL);
                    $this->redirect(array('view','id'=>$model->id));
                } catch (Exception $e) {
                    $transaction->rollback();
                    $connection->autoCommit=TRUE;
                    throw new CHttpException(403, $e->getMessage());
                }
            }
            
            Yii::app()->session->add('eappform', $model);
            Yii::app()->session->add('mining', $mining);
	    }
	    
	    $this->render('createMining',array(
	        'model'=>$model,
	        'mining'=>$mining,
	        'projectSite'=>$projectSite,
	        'investCompany'=>$investCompany,
	    ));
	}
	
	public function actionUpdateMining($id)
	{
	    $model = $this->loadModel($id, 'ApplicationForm');
	    $mining = $this->loadModel($id, 'Mining');
	    $projectSite = new MiningProjectSite;
        $investCompany = new InvestCompany;

        //Mining Session
        if (Yii::app()->session->get('mining') != NULL) {
            $mining = Yii::app()->session->get('mining');
        } else {
            Yii::app()->session->add('mining', $mining);
        }
        
        //Application Form Session
        if (Yii::app()->session->get('eappform') != NULL) {
            $model = Yii::app()->session->get('eappform');
        } else {
            Yii::app()->session->add('eappform', $model);
        }
        
        //Form submit
        if (isset($_POST['ApplicationForm']) && isset($_POST['Mining'])) {
            $model->setAttributes($_POST['ApplicationForm']);
	        $mining->setAttributes($_POST['Mining']);
	        
	        $validateArray = array(
                'company_name',
                'objective',
                'total_capital',
                'capital',
                'fixed_asset',
                'current_asset',
            );
            
            //Validate Mininig
            if ($mining->validate($validateArray)) {
                $connection = Yii::app()->db;
                $connection->autoCommit=FALSE;
                $transaction = $connection->beginTransaction();
                try {
                    if ($model->save()) {                        
                        //Save Invest company
                        if (count($model->invests) > 0) {
                            InvestCompany::model()->deleteAllByAttributes(array(
                                'application_form_id'=>$model->id
                            ));
                            foreach ($model->invests as $invest) {
                                $investCompany = new InvestCompany;
                                $investCompany->application_form_id = $model->id;
                                $investCompany->company_name = $invest->company_name;
                                $investCompany->register_place = $invest->register_place;
                                $investCompany->register_date = $invest->register_date;
                                $investCompany->total_capital = $invest->total_capital;
                                $investCompany->capital = $invest->capital;
                                $investCompany->president_first_name = $invest->president_first_name;
                                $investCompany->president_last_name = $invest->president_last_name;
                                $investCompany->president_nationality = $invest->president_nationality;
                                $investCompany->president_position = $invest->president_position;
                                $investCompany->headquarter_address = $invest->headquarter_address;
                                $investCompany->business_sector_id = $invest->business_sector_id;
                                $investCompany->save();
                            }
                        }

                        if ($mining->save()) {
                            if (count($mining->sites) > 0) {
                                MiningProjectSite::model()->deleteAllByAttributes(array(
                                    'mining_application_form_id'=>$mining->application_form_id
                                ));
                                
                                foreach ($mining->sites as $site) {
                                    $projectSite = new MiningProjectSite;
                                    $projectSite->mining_application_form_id = $mining->application_form_id;
                                    $projectSite->province_id = $site->province_id;
                                    $projectSite->district_id = $site->district_id;
                                    $projectSite->village_id = $site->village_id;
                                    $projectSite->save();
                                }
                            }
                        } else {
                            throw new Exception('Cannot save application1');
                        }
                    } else {
                        throw new Exception('Cannot save application2');
                    }
                    
                    $this->sendMail($model);
                    
                    $transaction->commit();
                    $connection->autoCommit=TRUE;
                    Yii::app()->session->add('eappform', NULL);
                    Yii::app()->session->add('mining', NULL);
                    $this->redirect(array('view','id'=>$model->id));
                } catch (Exception $e) {
                    $transaction->rollback();
                    $connection->autoCommit=TRUE;
                    throw new CHttpException(403, $e->getMessage());
                }
            }
            Yii::app()->session->add('eappform', $model);
            Yii::app()->session->add('mining', $mining);
        }
        
        $this->render('updateMining',array(
	        'model'=>$model,
	        'mining'=>$mining,
	        'projectSite'=>$projectSite,
	        'investCompany'=>$investCompany,
	    ));
	}
	
	public function actionCreateGeneral()
	{
	    $model = new ApplicationForm;
	    $general = new General;
        $model->inc_document_id = $this->inc_document_id;
        $model->application_type_id = ApplicationType::GENERAL;
        $projectSite = new GeneralProjectSite;
        $investCompany = new InvestCompany;
        
        //General Session
        if (Yii::app()->session->get('general') != NULL) {
            $general = Yii::app()->session->get('general');
        } else {
            Yii::app()->session->add('general', $general);
        }
        
        //Application Form Session
        if (Yii::app()->session->get('eappform') != NULL) {
            $model = Yii::app()->session->get('eappform');
        } else {
            Yii::app()->session->add('eappform', $model);
        }
	    
	    if (isset($_POST['ApplicationForm']) && isset($_POST['General'])) {
	        $model->setAttributes($_POST['ApplicationForm']);
	        $general->setAttributes($_POST['General']);
	        $model->unsetAttributes(array('id'));
	        $general->unsetAttributes(array('application_form_id'));
	       
            $model->inc_document_id = $this->inc_document_id;
            $model->application_type_id = ApplicationType::GENERAL;
            
            $validateArray = array(
                'project_name',
                'company_name',
                'mou',
                'develop_contract',
                'concession_contract',
            );
            
            if ($general->validate($validateArray)) {
                $connection = Yii::app()->db;
                $connection->autoCommit=FALSE;
                $transaction = $connection->beginTransaction();
                
                try {
                    if ($model->save()) {
                        //Set app id to general
                        $general->application_form_id=$model->id;
                         
                        //Save Invest company
                        if (count($model->invests) > 0) {
                            InvestCompany::model()->deleteAllByAttributes(array(
                                'application_form_id'=>$model->id
                            ));
                            foreach ($model->invests as $invest) {
                                $investCompany = new InvestCompany;
                                $investCompany->application_form_id = $model->id;
                                $investCompany->company_name = $invest->company_name;
                                $investCompany->register_place = $invest->register_place;
                                $investCompany->register_date = $invest->register_date;
                                $investCompany->total_capital = $invest->total_capital;
                                $investCompany->capital = $invest->capital;
                                $investCompany->president_first_name = $invest->president_first_name;
                                $investCompany->president_last_name = $invest->president_last_name;
                                $investCompany->president_nationality = $invest->president_nationality;
                                $investCompany->president_position = $invest->president_position;
                                $investCompany->headquarter_address = $invest->headquarter_address;
                                $investCompany->business_sector_id = $invest->business_sector_id;
                                $investCompany->save();
                            }
                        }
            
                        //$general->save();
                        if ($general->save()) {
                            if (count($general->sites) > 0) {
                                GeneralProjectSite::model()->deleteAllByAttributes(array(
                                    'general_application_form_id'=>$general->application_form_id
                                ));
                                
                                foreach ($general->sites as $site) {
                                    $projectSite = new GeneralProjectSite;
                                    $projectSite->general_application_form_id = $general->application_form_id;
                                    $projectSite->province_id = $site->province_id;
                                    $projectSite->district_id = $site->district_id;
                                    $projectSite->village_id = $site->village_id;
                                    $projectSite->save();
                                }
                            }
                        } else {
                            throw new Exception('Cannot save application1');
                        }
                    } else {
                        throw new Exception('Cannot save application2');
                    }
                    
                    $this->sendMail($model);
                    
                    $transaction->commit();
                    $connection->autoCommit=TRUE;
                    
                    Yii::app()->session->add('eappform', NULL);
                    Yii::app()->session->add('general', NULL);
                    $this->redirect(array('view','id'=>$model->id));
                } catch (Exception $e) {
                    $transaction->rollback();
                    $connection->autoCommit=TRUE;
                    throw new CHttpException(403, $e->getMessage());
                }
            }
            
            Yii::app()->session->add('eappform', $model);
            Yii::app()->session->add('general', $general);
	    }
	    
	    $this->render('createGeneral',array(
	        'model'=>$model,
	        'general'=>$general,
	        'projectSite'=>$projectSite,
	        'investCompany'=>$investCompany,
	    ));
	}
	
	public function actionUpdateGeneral($id)
	{
	    $model = $this->loadModel($id, 'ApplicationForm');
	    $general = $this->loadModel($id, 'General');
	    $projectSite = new GeneralProjectSite;
        $investCompany = new InvestCompany;

        //Generalt Session
        if (Yii::app()->session->get('general') != NULL) {
            $general = Yii::app()->session->get('general');
        } else {
            Yii::app()->session->add('general', $general);
        }
        
        //Application Form Session
        if (Yii::app()->session->get('eappform') != NULL) {
            $model = Yii::app()->session->get('eappform');
        } else {
            Yii::app()->session->add('eappform', $model);
        }
        
        //Form submit
        if (isset($_POST['ApplicationForm']) && isset($_POST['General'])) {
            $model->setAttributes($_POST['ApplicationForm']);
	        $general->setAttributes($_POST['General']);
	        
	        $validateArray = array(
                'project_name',
                'company_name',
                'mou',
                'develop_contract',
                'concession_contract',
            );
            
            //Validate General
            if ($general->validate($validateArray)) {
                $connection = Yii::app()->db;
                $connection->autoCommit=FALSE;
                $transaction = $connection->beginTransaction();
                try {
                    if ($model->save()) {                        
                        //Save Invest company
                        if (count($model->invests) > 0) {
                            InvestCompany::model()->deleteAllByAttributes(array(
                                'application_form_id'=>$model->id
                            ));
                            foreach ($model->invests as $invest) {
                                $investCompany = new InvestCompany;
                                $investCompany->application_form_id = $model->id;
                                $investCompany->company_name = $invest->company_name;
                                $investCompany->register_place = $invest->register_place;
                                $investCompany->register_date = $invest->register_date;
                                $investCompany->total_capital = $invest->total_capital;
                                $investCompany->capital = $invest->capital;
                                $investCompany->president_first_name = $invest->president_first_name;
                                $investCompany->president_last_name = $invest->president_last_name;
                                $investCompany->president_nationality = $invest->president_nationality;
                                $investCompany->president_position = $invest->president_position;
                                $investCompany->headquarter_address = $invest->headquarter_address;
                                $investCompany->business_sector_id = $invest->business_sector_id;
                                $investCompany->save();
                            }
                        }

                        if ($general->save()) {
                            if (count($general->sites) > 0) {
                                GeneralProjectSite::model()->deleteAllByAttributes(array(
                                    'general_application_form_id'=>$general->application_form_id
                                ));
                                
                                foreach ($general->sites as $site) {
                                    $projectSite = new GeneralProjectSite;
                                    $projectSite->general_application_form_id = $general->application_form_id;
                                    $projectSite->province_id = $site->province_id;
                                    $projectSite->district_id = $site->district_id;
                                    $projectSite->village_id = $site->village_id;
                                    $projectSite->save();
                                }
                            }
                        } else {
                            throw new Exception('Cannot save application1');
                        }
                    } else {
                        throw new Exception('Cannot save application2');
                    }
                    
                    $this->sendMail($model);
                    
                    $transaction->commit();
                    $connection->autoCommit=TRUE;
                    Yii::app()->session->add('eappform', NULL);
                    Yii::app()->session->add('general', NULL);
                    $this->redirect(array('view','id'=>$model->id));
                } catch (Exception $e) {
                    $transaction->rollback();
                    $connection->autoCommit=TRUE;
                    throw new CHttpException(403, $e->getMessage());
                }
            }
            Yii::app()->session->add('eappform', $model);
            Yii::app()->session->add('general', $general);
        }
        
        $this->render('updateGeneral',array(
	        'model'=>$model,
	        'general'=>$general,
	        'projectSite'=>$projectSite,
	        'investCompany'=>$investCompany,
	    ));
	}
	
	public function actionCreateRepOffice()
	{
	    $model = new ApplicationForm;
	    $repoffice = new RepOffice;
        $model->inc_document_id = $this->inc_document_id;
        $model->application_type_id = ApplicationType::REPRESENTATIVE;
        
        //RepOffice Session
        if (Yii::app()->session->get('repoffice') != NULL) {
            $repoffice = Yii::app()->session->get('repoffice');
        } else {
            Yii::app()->session->add('repoffice', $repoffice);
        }
        
        //Application Form Session
        if (Yii::app()->session->get('eappform') != NULL) {
            $model = Yii::app()->session->get('eappform');
        } else {
            Yii::app()->session->add('eappform', $model);
        }
	    
	    if (isset($_POST['ApplicationForm']) && isset($_POST['RepOffice'])) {
	        $model->setAttributes($_POST['ApplicationForm']);
	        $repoffice->setAttributes($_POST['RepOffice']);
	        $model->unsetAttributes(array('id'));
	        $repoffice->unsetAttributes(array('application_form_id'));
            $model->inc_document_id = $this->inc_document_id;
            $model->application_type_id = ApplicationType::REPRESENTATIVE;
            
            $validateArray = array(
                'first_name',
                'last_name',
                'birth_date',
                'nationality_id',
                'parent_company',
                'register_place',
                'business',
                'objective',
                'house_no',
                'province_id',
                'district_id',
                'village_id',
                'capital',
                'fixed_asset',
                'cash',
            );
            
            if ($repoffice->validate($validateArray)) {
                $connection = Yii::app()->db;
                $connection->autoCommit=FALSE;
                $transaction = $connection->beginTransaction();
                try {
                    if ($model->save()) {
                        //Set app id to repoffice
                        $repoffice->application_form_id=$model->id;
                        
                        if (!$repoffice->save()) {
                            throw new Exception('Cannot save RepOffice');
                        }
                    } else {
                        throw new Exception('Cannot save application');
                    }
                    
                    $this->sendMail($model);
                    
                    $transaction->commit();
                    $connection->autoCommit=TRUE;
                    
                    Yii::app()->session->add('eappform', NULL);
                    Yii::app()->session->add('repoffice', NULL);
                    $this->redirect(array('view','id'=>$model->id));
                } catch (Exception $e) {
                    $transaction->rollback();
                    $connection->autoCommit=TRUE;
                    throw new CHttpException(403, $e->getMessage());
                }
            }
            
            Yii::app()->session->add('eappform', $model);
            Yii::app()->session->add('repoffice', $repoffice);
	    }
	    
	    $this->render('createRepOffice',array(
	        'model'=>$model,
	        'repoffice'=>$repoffice,
	    ));
	}
	
	public function actionUpdateRepOffice($id)
	{
	    $model = $this->loadModel($id, 'ApplicationForm');
	    $repoffice = RepOffice::model()->findByAttributes(array(
	        'application_form_id'=>$model->id
	    ));
        
        //RepOffice Session
        if (Yii::app()->session->get('repoffice') != NULL) {
            $repoffice = Yii::app()->session->get('repoffice');
        } else {
            Yii::app()->session->add('repoffice', $repoffice);
        }
        
        //Application Form Session
        if (Yii::app()->session->get('eappform') != NULL) {
            $model = Yii::app()->session->get('eappform');
        } else {
            Yii::app()->session->add('eappform', $model);
        }
	    
	    if (isset($_POST['ApplicationForm']) && isset($_POST['RepOffice'])) {
	        $model->setAttributes($_POST['ApplicationForm']);
	        $repoffice->setAttributes($_POST['RepOffice']);
            
            $validateArray = array(
                'first_name',
                'last_name',
                'birth_date',
                'nationality_id',
                'parent_company',
                'register_place',
                'business',
                'objective',
                'house_no',
                'province_id',
                'district_id',
                'village_id',
                'capital',
                'fixed_asset',
                'cash',
            );
            
            if ($repoffice->validate($validateArray)) {
                $connection = Yii::app()->db;
                $connection->autoCommit=FALSE;
                $transaction = $connection->beginTransaction();
                try {
                    if ($model->save()) {                        
                        if (!$repoffice->save()) {
                            throw new Exception('Cannot save RepOffice');
                        }
                    } else {
                        throw new Exception('Cannot save application');
                    }
                    
                    $this->sendMail($model);
                    
                    $transaction->commit();
                    $connection->autoCommit=TRUE;
                    Yii::app()->session->add('eappform', NULL);
                    Yii::app()->session->add('repoffice', NULL);
                    $this->redirect(array('view','id'=>$model->id));
                } catch (Exception $e) {
                    $transaction->rollback();
                    $connection->autoCommit=TRUE;
                    throw new CHttpException(403, $e->getMessage());
                }
            }
            
            Yii::app()->session->add('eappform', $model);
            Yii::app()->session->add('repoffice', $repoffice);
	    }
	    
	    $this->render('updateRepOffice',array(
	        'model'=>$model,
	        'repoffice'=>$repoffice,
	    ));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'ApplicationForm');
		
		switch ($model->application_type_id) {
		    case ApplicationType::ELECTRICITY:
		        $this->redirect(array('updateElectric','id'=>$model->id));
		    break;
		    case ApplicationType::MINING:
		        $this->redirect(array('updateMining','id'=>$model->id));
		        break;
		    case ApplicationType::GENERAL:
		        $this->redirect(array('updateGeneral','id'=>$model->id));
		        break;
		    case ApplicationType::REPRESENTATIVE:
		        $this->redirect(array('updateRepOffice','id'=>$model->id));
		        break;
		    default:
		        break;
		}
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'ApplicationForm')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
	    Yii::app()->session->add('eappform', NULL);
	    Yii::app()->session->add('electric', NULL);
	    Yii::app()->session->add('mining', NULL);
	    Yii::app()->session->add('general', NULL);
	    Yii::app()->session->add('repoffice', NULL);
	    
		$model = new ApplicationForm('search');
		$model->unsetAttributes();

		if (isset($_GET['ApplicationForm']))
			$model->setAttributes($_GET['ApplicationForm']);

		$this->render('index', array(
			'model' => $model,
		));
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CController::filters()
	 */
	public function filters()
	{
	    $filter = array(
	        'documentContext +create, createElectric, createMining, createGeneral, createRepOffice',
	    );
	    return array_merge(parent::filters(),$filter);
	}
	
	
	public function filterDocumentContext($filterChain)
	{
	    if (isset($_GET['docid'])) {
	        $doc = Yii::app()->controller->module->documentClass;
	        $docId = Yii::app()->controller->module->documentId;
	        $indocument = $this->loadModel((int)$_GET['docid'], $doc);
	        if ($indocument === NULL) {
	            throw  new CHttpException(403, 'Document not found');
	        }
	        $this->inc_document_id = $indocument->$docId;
	    } else {
	        throw new CHttpException(403, 'Document must be loaded');
	    }
	    $filterChain->run();
	}
	
	public function actionAddSite()
	{
	    if (isset($_POST['ElectricProjectSite'])) {
	        $site = new ElectricProjectSite;
	        $site->attributes=$_POST['ElectricProjectSite'];
	        if (Yii::app()->session->get('electric') != NULL) {
	            $thesite = Yii::app()->session->get('electric');
	            $thesite->addSite($site);
	        }
	    }
	    
	    if (isset($_POST['MiningProjectSite'])) {
	        $site = new MiningProjectSite;
	        $site->attributes=$_POST['MiningProjectSite'];
	        if (Yii::app()->session->get('mining') != NULL) {
	            $thesite = Yii::app()->session->get('mining');
	            $thesite->addSite($site);
	        }
	    }
	    
	    if (isset($_POST['GeneralProjectSite'])) {
	        $site = new GeneralProjectSite;
	        $site->attributes=$_POST['GeneralProjectSite'];
	        if (Yii::app()->session->get('general') != NULL) {
	            $thesite = Yii::app()->session->get('general');
	            $thesite->addSite($site);
	        }
	    }	    
	}
	
	public function actionRemoveSite()
	{
	    if (isset($_GET['province_id']) && isset($_GET['district_id']) && isset($_GET['village_id']) && isset($_GET['app_type'])) {
	        $appType = null;
	        switch ($_GET['app_type']) {
	            case 'electric':
	                $appType = Yii::app()->session->get('electric');
	                break;
	            case 'mining':
	                $appType = Yii::app()->session->get('mining');
	                break;
	            case 'general':
	                $appType = Yii::app()->session->get('general');
	                break;
	        }
	        if ($appType != NULL) {
	            $sites = $appType->getSiteProvider()->getData();
	            foreach ($sites as $i=>$site) {
	                if ($site['province_id']==$_GET['province_id'] 
	                && $site['district_id']==$_GET['district_id'] 
	                && $site['village_id']==$_GET['village_id']) {
	                    $appType->removeSite($site);
	                    unset($sites[$i]);
	                    break;
	                }
	            }
	        }
	    }
	}
	
	public function actionAddInvest()
	{
	    $invest = new InvestCompany;
	    if (isset($_POST['InvestCompany'])) {
	        $invest->attributes=$_POST['InvestCompany'];
	        if (Yii::app()->session->get('eappform') != NULL) {
	            $theapp = Yii::app()->session->get('eappform');
	            $theapp->addInvest($invest);
	        }
	    }
	}
	
	public function actionRemoveInvest()
	{
	    if (isset($_GET['company_name'])) {
	        $appform = Yii::app()->session->get('eappform');
	        if ($appform != NULL) {
	            $invests = $appform->getInvestProvider()->getData();
	            foreach ($invests as $i=>$invest) {
	                if ($invest['company_name']==$_GET['company_name']) {
	                    $appform->removeInvest($invest);
	                    unset($invests[$i]);
	                    break;
	                }
	            }
	        }
	    }
	}
	
	public function actions()
	{
	    return array(
	        'districtDropDownList'=>array(
	            'class'=>'appform.components.DistrictDropDownListAction',
	            'modelClass'=>'ElectricProjectSite',
	        ),
	        'villageDropDownList'=>array(
	            'class'=>'appform.components.VillageDropDownListAction',
	            'modelClass'=>'ElectricProjectSite',
	        ),
	        'districtDropDownList2'=>array(
	            'class'=>'appform.components.DistrictDropDownListAction',
	            'modelClass'=>'MiningProjectSite',
	        ),
	        'villageDropDownList2'=>array(
	            'class'=>'appform.components.VillageDropDownListAction',
	            'modelClass'=>'MiningProjectSite',
	        ),
	        'districtDropDownList3'=>array(
	            'class'=>'appform.components.DistrictDropDownListAction',
	            'modelClass'=>'GeneralProjectSite',
	        ),
	        'villageDropDownList3'=>array(
	            'class'=>'appform.components.VillageDropDownListAction',
	            'modelClass'=>'GeneralProjectSite',
	        ),
	        'districtDropDownList4'=>array(
	            'class'=>'appform.components.DistrictDropDownListAction',
	            'modelClass'=>'RepOffice',
	        ),
	        'villageDropDownList4'=>array(
	            'class'=>'appform.components.VillageDropDownListAction',
	            'modelClass'=>'RepOffice',
	        ),
	        
	         'districtDropDownList5'=>array(
	            'class'=>'appform.components.DistrictDropDownListAction',
	            'modelClass'=>'Electric',
	        ),
	        'villageDropDownList5'=>array(
	            'class'=>'appform.components.VillageDropDownListAction',
	            'modelClass'=>'Electric',
	        ),
	        
	        'districtDropDownList6'=>array(
	            'class'=>'appform.components.DistrictDropDownListAction',
	            'modelClass'=>'Mining',
	        ),
	        'villageDropDownList6'=>array(
	            'class'=>'appform.components.VillageDropDownListAction',
	            'modelClass'=>'Mining',
	        ),
	        'districtDropDownList7'=>array(
	            'class'=>'appform.components.DistrictDropDownListAction',
	            'modelClass'=>'General',
	        ),
	        'villageDropDownList7'=>array(
	            'class'=>'appform.components.VillageDropDownListAction',
	            'modelClass'=>'General',
	        ),
	    );
	}
	
	public function actionViewByDocument($id)
	{
	    $model = ApplicationForm::model()->findByAttributes(array(
	        'inc_document_id'=>(int)$id
	    ));
	    
	    if ($model != NULL) {
	        $this->redirect(array('view','id'=>$model->id));
	    } else {
	        throw new CHttpException(403, 'Application not found');
	    }
	}
	
	public function actionViewInvestModal($id)
	{
        if( Yii::app()->request->isAjaxRequest ) {
            $this->renderPartial('viewInvest',array(
                'model'=>$this->loadModel($id,'InvestCompany'),
            ), false, true);
        } else {
            $this->render('viewInvest',array(
                'model'=>$this->loadModel($id,'InvestCompany'),
            ));
        }
	}
	
	public function actionShowrelate()
	{
		$model=Document::model()->findByPk($_GET['docid']);
		//Document::model()->get_category_hr($model->id, $model->related_document_id, '');
		$this->renderPartial('popocer',array('model'=>$model));
	}

}