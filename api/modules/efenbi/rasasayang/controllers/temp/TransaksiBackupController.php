<?php

namespace api\modules\efenbi\rasasayang\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\helpers\ArrayHelper;

use api\modules\efenbi\rasasayang\models\Transaksi;
use api\modules\efenbi\rasasayang\models\TransaksiSearch;

/**
 * TransaksiController implements the CRUD actions for Transaksi model.
 */
class TransaksiController extends ActiveController
{
    /**
      * Source Database declaration 
     */
    public $modelClass = 'api\modules\efenbi\rasasayang\models\TransaksiSearch';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'transaksi',
    ]; 
    
    /**
     * @inheritdoc
     */
    public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                 // ['class' => HttpBearerAuth::className()],
                 // ['class' => QueryParamAuth::className()],//, 'tokenParam' => 'access-token'],
                ]
            ], 
            'bootstrap'=> [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,'charset' => 'UTF-8',
                ],
                'languages' => [
                    'en',
                    'de',
                ],
            ],          
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'PUT','GET'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ]       
            ],
        ]);
        
    }
    
    public function actions()
    {       
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => function () {
                    
                    $param=["TransaksiSearch"=>Yii::$app->request->queryParams];
                    //return $param;
                    $searchModel = new TransaksiSearch();
                    return $searchModel->search($param);
                },
            ],
        ];
    } 

    /**
     * Lists all Transaksi models.
     * @return mixed
     */
    // public function actionIndex()
    // {
        // $searchModel = new TransaksiSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
        // ]);
    // }

    /**
     * Displays a single Transaksi model.
     * @param integer $id
     * @return mixed
     */
    // public function actionView($id)
    // {
        // return $this->render('view', [
            // 'model' => $this->findModel($id),
        // ]);
    // }
     // public function actions()
    // {
        // $actions = parent::actions();
        // unset($actions['create']);
        // return $actions;
    // } 
    /**
     * Creates a new Transaksi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $model      = new Transaksi();
        $params     = $_REQUEST;        
        $model->attributes=$params;
        // $model->CREATE_AT = date('Y:m:d H:i:s');//'2017-12-12 00:00';
        $model->UPDATE_AT = date('Y:m:d H:i:s');//'2017-12-12 00:00';
        $model->TRANS_DATE = date('Y:m:d H:i:s');//'2017-12-12 00:00';
        //ERROR
        $model->ITEM_HARGA = 100000;
        $model->ITEM_DISCOUNT = 10;
        if ($model->save()) 
        {
            return $model->attributes;
        } 
        else
        {
            return array('errors'=>$model->errors);
        } 
        
    }

    /**
     * Updates an existing Transaksi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    /* public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    } */

    /**
     * Deletes an existing Transaksi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
   /*  public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    } */

    /**
     * Finds the Transaksi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaksi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
  /*   protected function findModel($id)
    {
        if (($model = Transaksi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    } */
}
