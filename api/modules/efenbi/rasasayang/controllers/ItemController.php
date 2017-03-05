<?php

namespace lukisongroup\efenbi\rasasayang\controllers;

use Yii;
use lukisongroup\efenbi\rasasayang\models\Item;
use lukisongroup\efenbi\rasasayang\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
	/*
	* Declaration Component User Permission
	* Function getPermission
	* Modul Name[11=Calendar Promo]
	* Permission LINK URL.
	*/
	public function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('11')){
			return Yii::$app->getUserOpt->Modul_akses('11');
		}else{
			return false;
		}
	}  
	/**
     * Before Action Index
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	public function beforeAction($action){
		if (Yii::$app->user->isGuest)  {
			 Yii::$app->user->logout();
			   $this->redirect(array('/site/login'));  //
		}
		// Check only when the user is logged in
		if (!Yii::$app->user->isGuest)  {
		   if (Yii::$app->session['userSessionTimeout']< time() ) {
			   // timeout
			   Yii::$app->user->logout();
			   $this->redirect(array('/site/login'));  //
		   } else {
			   //Yii::$app->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']) ;
			   Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
			   //Modul permission URL, author -ptr.nov@gail.com-
			   if(self::getPermission()->BTN_CREATE OR self::getPermission()->BTN_VIEW){
					return true;
			   }else{
				   $this->redirect(array('/site/validasi'));
			   }
		   }
		} else {
			return true;
		}
    }
    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
		$paramCari=Yii::$app->getRequest()->getQueryParam('id');
		if($paramCari){
		    $searchModel = new ItemSearch(['ITEM_ID'=>$paramCari]);
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		}else{
			$searchModel = new ItemSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		}
       

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			$editUploadImage = $model->uploadImage();
			$image64edit=$editUploadImage != ''? $this->convertBase64(file_get_contents($editUploadImage->tempName)): '';
			$model->IMG64 = $image64edit;
			$model->UPDATE_BY =  Yii::$app->user->identity->username;
			// print_r($image64edit);
			// die();
			if($model->save()){
				if ($editUploadImage !== false) {
					$path=$model->pathImage();					
					$editUploadImage->saveAs($path);
					// print_r($path);
					// die();
				}
				return $this->redirect(['index', 'id' => $model->ITEM_ID]);
			}			
        } else {
            return $this->renderAjax('view', [
				'model' => $this->findModel($id),
			]);
        }
    }

    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Item();
		//$model->scenario = "create";		
        if ($model->load(Yii::$app->request->post())) {
			//Image Base64
				$ambilUploadImage = $model->uploadImage();
				$image64=$ambilUploadImage != ''? $this->convertBase64(file_get_contents($ambilUploadImage->tempName)): '';
			//Generate Code.
				$maxID=Item::find()->max('ITEM_ID');
				$newID=str_pad($maxID+1,4,"0",STR_PAD_LEFT);
			//Attribute -Save-
				$model->ITEM_ID =$newID;
				$model->CREATE_BY =  Yii::$app->user->identity->username;
				$model->CREATE_AT = date("Y-m-d H:i:s");
				$model->IMG64 = $image64;
			if ( $model->save()){
				if ($ambilUploadImage !== false) {
					$path=$model->pathImage();					
					$ambilUploadImage->saveAs($path);
					// print_r($path);
					// die();
				}
			}
			
            //return $this->redirect(['view', 'id' => $model->ITEM_ID]);
			return $this->redirect(['index', 'id' => $model->ITEM_ID]);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

	 public function actionValidItem()
    {
		$model = new Item();
		$model->scenario = "create";
		if(Yii::$app->request->isAjax && $model->load($_POST))
		{
			Yii::$app->response->format = 'json';
			return ActiveForm::validate($model);
		}
		return 'test';
    }
	
    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ITEM_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        //if (($model = Item::findOne(['ITEM_ID'=>$id])) !== null) {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function convertBase64($base64)
    {
      $base64 = str_replace('data:image/jpg;base64,', '', $base64);
      $base64 = base64_encode($base64);
      $base64 = str_replace(' ', '+', $base64);

      return $base64;

    }
}
